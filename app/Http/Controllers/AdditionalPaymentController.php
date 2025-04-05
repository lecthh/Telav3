<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\AdditionalPayment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Traits\Toastable;

class AdditionalPaymentController extends Controller
{
    use Toastable;

    /**
     * Show the payment details page
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $order_id
     * @return \Illuminate\Http\Response
     */
    public function showPaymentDetails(Request $request, $order_id)
    {
        $order = Order::where('order_id', $order_id)->firstOrFail();
        $amount = $request->query('amount', 0);
        $isBalancePayment = $request->query('is_balance_payment', 0) == 1;
        
        // Get the production company information
        $productionCompany = $order->productionCompany;
        
        // Calculate original order details
        $unitPrice = $order->final_price / $order->quantity;
        $originalQuantity = $order->quantity;
        $originalPrice = $order->final_price;
        
        // Get total amount of previous additional payments
        $previousPayments = $order->additionalPayments()->sum('amount');
        
        if ($isBalancePayment) {
            // For balance payments, we keep the original quantity
            $additionalQuantity = 0;
            $newQuantity = $originalQuantity;
            $newTotalPrice = $originalPrice;
            // We still set balanceDue to 0, but the amount they pay is the actual balance
            // which is calculated as the total price minus the downpayment and any previous additional payments
            $amount = $originalPrice - $order->downpayment_amount - $previousPayments;
            $balanceDue = 0; // Since they're paying the full balance
        } else {
            // For additional orders
            $additionalQuantity = $request->query('quantity', 0);
            $newQuantity = $originalQuantity + $additionalQuantity;
            $newTotalPrice = $unitPrice * $newQuantity;
            // Include previous payments in the balance calculation
            $balanceDue = $newTotalPrice - $order->downpayment_amount - $previousPayments - $amount;
        }
        
        // Create a fake account number
        $accountNumber = '1234' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        
        return view('customer.payment.additional-payment', compact(
            'order',
            'amount',
            'additionalQuantity',
            'productionCompany',
            'unitPrice',
            'originalQuantity',
            'originalPrice',
            'newQuantity',
            'newTotalPrice',
            'balanceDue',
            'accountNumber',
            'isBalancePayment',
            'previousPayments'
        ));
    }

    /**
     * Process the payment and confirm the order
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $order_id
     * @return \Illuminate\Http\Response
     */
    public function processPayment(Request $request, $order_id)
    {
        try {
            // Check if this is a balance payment or additional order
            $isBalancePayment = $request->has('is_balance_payment') && $request->is_balance_payment === "1";
            
            if ($isBalancePayment) {
                // Validation for balance payment only
                $request->validate([
                    'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'amount' => 'required|numeric|min:0',
                ]);
            } else {
                // Validation for additional items
                $request->validate([
                    'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'amount' => 'required|numeric|min:0',
                    'additional_quantity' => 'required|integer|min:1',
                    'new_total_quantity' => 'required|integer|min:1',
                    'size_data' => 'nullable|string' // JSON string of previously entered size data
                ]);
            }

            $order = Order::where('order_id', $order_id)->firstOrFail();
            
            // Save the payment proof
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            }
            
            // Create payment record
            $additionalPayment = new AdditionalPayment([
                'order_id' => $order->order_id,
                'amount' => $request->amount,
                'additional_quantity' => $isBalancePayment ? 0 : $request->additional_quantity,
                'payment_proof' => $paymentProofPath,
                'status' => 'completed',
            ]);
            
            $additionalPayment->save();
            
            if (!$isBalancePayment) {
                // Only update quantity and price for additional orders, not for balance payments
                $unitPrice = $order->final_price / $order->quantity;
                $newTotalPrice = $unitPrice * $request->new_total_quantity;
                
                $order->quantity = $request->new_total_quantity;
                $order->final_price = $newTotalPrice;
                
                // Process customization data from the form
                if ($request->has('size_data') && !empty($request->size_data)) {
                    $this->processCustomizationData($order, $request->size_data);
                }
            }
            
            // Invalidate token to indicate order is confirmed
            $order->token = null;
            
            $order->save();
            
            // Generate and send receipt
            $this->sendPaymentReceipt($order, $additionalPayment);
            
            // Create notification for production company
            \App\Models\Notification::create([
                'user_id' => $order->productionCompany->user_id,
                'message' => 'Additional payment received and order confirmed #' . $order->order_id,
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);
            
            // Create notification for customer
            \App\Models\Notification::create([
                'user_id' => $order->user_id,
                'message' => 'Your order has been confirmed. Order #' . $order->order_id,
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);
            
            // Redirect to order confirmation page instead of back to the form
            $this->toast('Your payment has been processed and your order is now confirmed!', 'success');
            return redirect()->route('customer.confirmation');
        } catch (\Exception $e) {
            Log::error('Additional Payment Processing Error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            $this->toast('An error occurred while processing your payment: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    private function sendPaymentReceipt($order, $payment)
    {
        try {
            $user = $order->user;
            $productionCompany = $order->productionCompany;
            $receiptNumber = 'RCP-' . date('Ymd') . '-' . uniqid();
            $unitPrice = $order->final_price / $order->quantity;
            
            // Calculate total payment amount including all previous payments
            $totalPayments = $order->downpayment_amount + $order->additionalPayments()->sum('amount');
            
            $receiptData = [
                'receipt_number' => $receiptNumber,
                'date' => now()->format('F d, Y'),
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'order_id' => $order->order_id,
                'production_company' => $productionCompany->company_name,
                'original_quantity' => $order->quantity - $payment->additional_quantity,
                'additional_quantity' => $payment->additional_quantity,
                'new_total_quantity' => $order->quantity,
                'unit_price' => $unitPrice,
                'additional_payment' => $payment->amount,
                'payment_date' => $payment->created_at->format('F d, Y'),
                'total_price' => $order->final_price,
                'balance_due' => $order->final_price - $totalPayments,
            ];
            
            // Send email with receipt
            Mail::send('customer.payment.payment-receipt', $receiptData, function ($message) use ($user, $receiptNumber) {
                $message->to($user->email);
                $message->subject('Receipt #' . $receiptNumber . ' - Additional Payment');
            });
            
            Log::info('Payment receipt sent to customer', [
                'order_id' => $order->order_id,
                'receipt_number' => $receiptNumber,
                'email' => $user->email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment receipt: ' . $e->getMessage(), [
                'order_id' => $order->order_id,
                'error' => $e
            ]);
        }
    }

        /**
     * Process customization data based on order type
     *
     * @param \App\Models\Order $order
     * @param string|null $sizeDataJson
     * @return void
     */
    private function processCustomizationData($order, $sizeDataJson)
    {
        if (empty($sizeDataJson)) {
            return;
        }
        
        try {
            $sizeData = json_decode($sizeDataJson, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON decode error in size data: ' . json_last_error_msg(), [
                    'order_id' => $order->order_id,
                    'size_data' => $sizeDataJson
                ]);
                return;
            }
            
            // Check if it's a standard order (key-value pairs) or customized order (array of objects)
            $isStandardFormat = !is_array(reset($sizeData)) && count($sizeData) > 0;
            
            if ($isStandardFormat) {
                // Standard order format: {"sizeId": quantity, "sizeId2": quantity2, ...}
                $this->processStandardSizes($order, $sizeData);
            } else {
                // Customized order format: [{"name": "...", "size": "...", ...}, {...}]
                $this->processCustomizedItems($order, $sizeData);
            }
        } catch (\Exception $e) {
            Log::error('Error processing customization data: ' . $e->getMessage(), [
                'order_id' => $order->order_id,
                'exception' => $e
            ]);
        }
    }

        /**
     * Process standard size format (quantity per size)
     *
     * @param \App\Models\Order $order
     * @param array $sizeData
     * @return void
     */
    private function processStandardSizes($order, $sizeData)
    {
        foreach ($sizeData as $sizeId => $quantity) {
            if ($quantity > 0) {
                \App\Models\CustomizationDetails::create([
                    'customization_details_ID' => uniqid(),
                    'order_ID' => $order->order_id,
                    'sizes_ID' => $sizeId,
                    'quantity' => $quantity,
                ]);
            }
        }
    }

    /**
     * Process customized items format (array of personalized items)
     *
     * @param \App\Models\Order $order
     * @param array $items
     * @return void
     */
    private function processCustomizedItems($order, $items)
    {
        foreach ($items as $item) {
            // Skip incomplete entries
            if (empty($item['name']) || empty($item['size'])) {
                continue;
            }
            
            // Check if this is a jersey item
            $isJersey = isset($item['jerseyNo']) && isset($item['topSize']) && isset($item['shortSize']);
            
            if ($isJersey) {
                // Create jersey customization
                \App\Models\CustomizationDetails::create([
                    'customization_details_ID' => uniqid(),
                    'order_ID' => $order->order_id,
                    'name' => $item['name'],
                    'jersey_number' => $item['jerseyNo'],
                    'sizes_ID' => $item['topSize'],
                    'short_size' => $item['shortSize'],
                    'has_pocket' => isset($item['hasPocket']) ? (bool) $item['hasPocket'] : false,
                    'remarks' => $item['remarks'] ?? null,
                    'quantity' => 1,
                ]);
            } else {
                // Create standard customization
                \App\Models\CustomizationDetails::create([
                    'customization_details_ID' => uniqid(),
                    'order_ID' => $order->order_id,
                    'sizes_ID' => $item['size'],
                    'name' => $item['name'],
                    'remarks' => $item['remarks'] ?? null,
                    'quantity' => 1,
                ]);
            }
        }
    }
}