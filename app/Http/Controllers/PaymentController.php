<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\CustomizationDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Traits\Toastable;

class PaymentController extends Controller
{
    use Toastable;

    /**
     * Show payment methods page
     */
    public function showPaymentMethods(Request $request, $order_id)
{
    $order = Order::findOrFail($order_id);
    
    $additionalPayment = $request->input('additional_payment', 0);
    Log::info('Payment request parameters', [
        'order_id' => $order_id,
        'request_all' => $request->all(),
        'additional_payment' => $request->input('additional_payment')
    ]);
    
    $productionCompany = $order->productionCompany;
    
    $quantity = session('new_quantity', $order->quantity);
    $unitPrice = $order->quantity > 0 ? ($order->final_price / $order->quantity) : 0;
    $originalDownpayment = $order->downpayment_amount;
    
    return view('customer.payment.payment-methods', compact(
        'order', 
        'additionalPayment', 
        'productionCompany',
        'quantity',
        'unitPrice',
        'originalDownpayment'
    ));
}

    /**
     * Process payment
     */
    public function processPayment(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'order_id' => 'required|exists:orders,order_id',
                'amount' => 'required|numeric|min:0',
                'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);

            DB::beginTransaction();
            
            $order = Order::where('order_id', $request->order_id)->firstOrFail();
            
            // Store payment proof
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            // Create payment record
            $payment = new Payment([
                'payment_id' => uniqid(),
                'order_id' => $order->order_id,
                'amount' => $request->amount,
                'payment_proof' => $paymentProofPath,
                'user_id' => Auth::id(),
                'payment_date' => now(),
                'status' => 'completed',
                'payment_type' => 'additional_payment'
            ]);
            $payment->save();
            
            // Process the order based on the confirmation type
            $confirmationType = session('confirmation_type');
            $orderData = session('order_confirmation_data');
            
            if (!$orderData || !$confirmationType) {
                throw new \Exception("Missing order confirmation data in session.");
            }
            
            // Calculate total quantity based on confirmation type
            $totalQuantity = 0;
            
            switch ($confirmationType) {
                case 'bulk_custom':
                case 'single_custom':
                    // Process rows with name and size
                    foreach ($orderData['rows'] as $row) {
                        if (!empty($row['name']) && !empty($row['size'])) {
                            CustomizationDetails::create([
                                'customization_details_ID' => uniqid(),
                                'order_ID' => $order->order_id,
                                'sizes_ID' => $row['size'],
                                'name' => $row['name'],
                                'remarks' => $row['remarks'] ?? null,
                                'quantity' => 1,
                            ]);
                            $totalQuantity++;
                        }
                    }
                    break;
                    
                case 'jersey_bulk_custom':
                    // Process rows with name, topSize, and shortSize
                    foreach ($orderData['rows'] as $row) {
                        if (!empty($row['name']) && !empty($row['topSize']) && !empty($row['shortSize'])) {
                            CustomizationDetails::create([
                                'customization_details_ID' => uniqid(),
                                'order_ID' => $order->order_id,
                                'name' => $row['name'],
                                'jersey_number' => $row['jerseyNo'],
                                'sizes_ID' => $row['topSize'],
                                'short_size' => $row['shortSize'],
                                'has_pocket' => isset($row['hasPocket']) ? (bool) $row['hasPocket'] : false,
                                'remarks' => $row['remarks'] ?? null,
                                'quantity' => 1,
                            ]);
                            $totalQuantity++;
                        }
                    }
                    break;
                
                default:
                    throw new \Exception("Unknown confirmation type: $confirmationType");
            }
            
            // Update order with new quantity and prices
            $unitPrice = $order->quantity > 0 ? ($order->final_price / $order->quantity) : 0;
            $order->quantity = $totalQuantity;
            $order->final_price = $unitPrice * $totalQuantity;
            
            // Remove token to indicate order is confirmed
            $order->token = null;
            $order->save();
            
            // Create notification for production company
            Notification::create([
                'user_id' => $order->productionCompany->user_id,
                'message' => 'Additional payment received for order #' . $order->order_id,
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);
            
            // Create notification for customer
            Notification::create([
                'user_id' => Auth::id(),
                'message' => 'Your payment for order #' . $order->order_id . ' has been received. Your order is now being processed.',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);
            
            DB::commit();
            
            // Clear session data
            session()->forget(['order_confirmation_data', 'confirmation_type']);
            
            // Log successful payment and order update
            Log::info('Payment processed and order updated successfully', [
                'order_id' => $order->order_id,
                'payment_amount' => $request->amount,
                'new_quantity' => $totalQuantity,
                'new_total_price' => $order->final_price,
                'user_id' => Auth::id()
            ]);
            
            // Return a successful response
            return response()->json([
                'success' => true,
                'message' => 'Payment successfully processed and order updated.',
                'redirect' => route('home')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Payment processing error: ' . $e->getMessage(), [
                'exception' => $e,
                'order_id' => $request->order_id ?? 'unknown',
                'user_id' => Auth::id() ?? 'unknown'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your payment: ' . $e->getMessage()
            ], 500);
        }
    }
}