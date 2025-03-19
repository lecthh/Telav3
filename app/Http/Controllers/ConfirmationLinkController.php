<?php

namespace App\Http\Controllers;

use App\Models\CustomizationDetails;
use App\Models\Order;
use App\Models\Sizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Traits\Toastable;

class ConfirmationLinkController extends Controller
{
    use Toastable;
    public function confirmBulkCustom(Request $request, $token)
    {
        $order = Order::where('order_id', $request->order_id)
            ->where('token', $token)
            ->firstOrFail();

        $rows = old('rows', array_fill(0, 10, ['name' => '', 'size' => '', 'remarks' => '']));

        $sizes = Sizes::all();

        return view('customer.order-confirmation.bulk-customized', compact('order', 'rows', 'sizes'));
    }


    public function confirmBulkCustomPost(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'order_id' => 'required|exists:orders,order_id',
                'token' => 'required|exists:orders,token',
                'rows.*.name' => 'required|string',
                'rows.*.size' => 'required|integer|exists:sizes,sizes_ID',
                'rows.*.remarks' => 'nullable|string',
                'additional_payment_required' => 'nullable|numeric'
            ]);

            $order = Order::where('order_id', $request->order_id)
                ->where('token', $request->token)
                ->firstOrFail();

            if (Auth::guest() || Auth::user()->email !== $order->user->email) {
                $this->toast('You are not authorized to confirm this order.', 'error');
                return redirect()->back();
            }

            $totalQuantity = count(array_filter($validatedData['rows'], function ($row) {
                return !empty($row['name']) && !empty($row['size']);
            }));

            if ($totalQuantity < 10) {
                $this->toast('You must have at least 10 customization entries.', 'error');
                return redirect()->back();
            }

            // Check if additional payment is required
            $additionalPaymentRequired = floatval($request->input('additional_payment_required', 0));
            if ($additionalPaymentRequired > 0) {
                session([
                    'order_confirmation_data' => $request->all(),
                    'confirmation_type' => 'bulk_custom'
                ]);
                
                return redirect()->route('customer.payment.methods', [
                    'order_id' => $order->order_id,
                    'additional_payment' => $additionalPaymentRequired
                ]);
            }

            DB::beginTransaction();
            try {
                // Clear any existing customization details for this order
                CustomizationDetails::where('order_ID', $order->order_id)->delete();
                
                // Create new customization details
                foreach ($request->rows as $row) {
                    if (!empty($row['name']) && !empty($row['size'])) {
                        CustomizationDetails::create([
                            'customization_details_ID' => uniqid(),
                            'order_ID' => $order->order_id,
                            'sizes_ID' => $row['size'],
                            'name' => $row['name'],
                            'remarks' => $row['remarks'] ?? null,
                            'quantity' => 1,
                        ]);
                    }
                }

                $unitPrice = $order->quantity > 0 ? ($order->final_price / $order->quantity) : 0;
                
                $order->quantity = $totalQuantity;
                $order->final_price = $unitPrice * $totalQuantity;
                $order->token = null;
                $order->save();
                
                // Create notification for production company/printer
                \App\Models\Notification::create([
                    'user_id' => $order->productionCompany->user_id,
                    'message' => 'Bulk customization details submitted for order #' . $order->order_id,
                    'is_read' => false,
                    'order_id' => $order->order_id,
                ]);
                
                DB::commit();
                
                Log::info('Order updated during bulk custom confirmation', [
                    'order_id' => $order->order_id,
                    'new_quantity' => $totalQuantity,
                    'new_price' => $order->final_price,
                    'user_id' => Auth::id()
                ]);

                $this->toast('Customization details submitted successfully!', 'success');
                return redirect()->route('home');
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error in confirmBulkCustomPost transaction: ' . $e->getMessage(), [
                    'exception' => $e,
                    'order_id' => $order->order_id
                ]);
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Error in confirmBulkCustomPost: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            $this->toast('An error occurred while submitting customization details.', 'error');
            return redirect()->back();
        }
    }

    public function confirmJerseyBulkCustom(Request $request, $token)
    {
        try {
            $order = Order::where('order_id', $request->order_id)
                ->where('token', $token)
                ->first();

            if (!$order) {
                $this->toast('Invalid token or order.', 'error');
                return redirect()->route('home');
            }

            $rows = old('rows', array_fill(0, 10, [
                'name' => '',
                'jerseyNo' => '',
                'topSize' => '',
                'shortSize' => '',
                'hasPocket' => '',
                'remarks' => ''
            ]));

            return view('customer.order-confirmation.jersey-bulk-customized', compact('order', 'rows'));
        } catch (\Exception $e) {
            Log::error('Error in confirmJerseyBulkCustom: ' . $e->getMessage(), [
                'exception' => $e,
                'order_id' => $request->order_id
            ]);
            $this->toast('An error occurred while confirming the jersey customization.', 'error');
            return redirect()->route('home');
        }
    }

    public function confirmJerseyBulkCustomPost(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'order_id' => 'required|exists:orders,order_id',
                'token' => 'required|exists:orders,token',
                'rows.*.name' => 'required|string',
                'rows.*.jerseyNo' => 'required|integer',
                'rows.*.topSize' => 'required|integer',
                'rows.*.shortSize' => 'required|integer',
                'rows.*.hasPocket' => 'nullable|boolean',
                'rows.*.remarks' => 'nullable|string',
                'additional_payment_required' => 'nullable|numeric'
            ]);

            $order = Order::where('order_id', $request->order_id)
                ->where('token', $request->token)
                ->firstOrFail();

            if (Auth::guest() || Auth::user()->email !== $order->user->email) {
                $this->toast('You are not authorized to confirm this order.', 'error');
                return redirect()->back();
            }

            $totalQuantity = count(array_filter($validatedData['rows'], function ($row) {
                return !empty($row['name']) && !empty($row['topSize']) && !empty($row['shortSize']);
            }));

            if ($totalQuantity < 10) {
                $this->toast('You must have at least 10 customization entries.', 'error');
                return redirect()->back();
            }

            // Check if additional payment is required
            $additionalPaymentRequired = floatval($request->input('additional_payment_required', 0));
            if ($additionalPaymentRequired > 0) {
                session([
                    'order_confirmation_data' => $request->all(),
                    'confirmation_type' => 'jersey_bulk_custom'
                ]);
                
                return redirect()->route('customer.payment.methods', [
                    'order_id' => $order->order_id,
                    'additional_payment' => $additionalPaymentRequired
                ]);
            }

            DB::beginTransaction();
            try {
                CustomizationDetails::where('order_ID', $order->order_id)->delete();
                
                foreach ($validatedData['rows'] as $row) {
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
                    }
                }

                $unitPrice = $order->quantity > 0 ? ($order->final_price / $order->quantity) : 0;
                
                $order->quantity = $totalQuantity;
                $order->final_price = $unitPrice * $totalQuantity;
                $order->token = null;
                $order->save();
                
                \App\Models\Notification::create([
                    'user_id' => $order->productionCompany->user_id,
                    'message' => 'Jersey customization details submitted for order #' . $order->order_id,
                    'is_read' => false,
                    'order_id' => $order->order_id,
                ]);
                
                DB::commit();
                
                Log::info('Order updated during jersey bulk custom confirmation', [
                    'order_id' => $order->order_id,
                    'new_quantity' => $totalQuantity,
                    'new_price' => $order->final_price,
                    'user_id' => Auth::id()
                ]);

                $this->toast('Jersey customization details submitted successfully!', 'success');
                return redirect()->route('home');
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error in confirmJerseyBulkCustomPost transaction: ' . $e->getMessage(), [
                    'exception' => $e,
                    'order_id' => $order->order_id
                ]);
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Error in confirmJerseyBulkCustomPost: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            $this->toast('An error occurred while submitting jersey customization details.', 'error');
            return redirect()->back();
        }
    }
    
    public function confirmSingleCustom(Request $request, $token)
    {
        $order = Order::where('order_id', $request->order_id)
            ->where('token', $token)
            ->firstOrFail();

        $rows = old('rows', array_fill(0, 1, ['name' => '', 'size' => '', 'remarks' => '']));

        $sizes = Sizes::all();

        return view('customer.order-confirmation.single-customized', compact('order', 'rows', 'sizes'));
    }

    public function confirmSingleCustomPost(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'order_id' => 'required|exists:orders,order_id',
                'token' => 'required|exists:orders,token',
                'rows.*.name' => 'required|string',
                'rows.*.size' => 'required|integer|exists:sizes,sizes_ID',
                'rows.*.remarks' => 'nullable|string',
                'additional_payment_required' => 'nullable|numeric'
            ]);

            $order = Order::where('order_id', $request->order_id)
                ->where('token', $request->token)
                ->firstOrFail();

            if (Auth::guest() || Auth::user()->email !== $order->user->email) {
                $this->toast('You are not authorized to confirm this order.', 'error');
                return redirect()->back();
            }

            $totalQuantity = count(array_filter($validatedData['rows'], function ($row) {
                return !empty($row['name']) && !empty($row['size']);
            }));

            if ($totalQuantity < 1) {
                $this->toast('You must provide at least one customization entry.', 'error');
                return redirect()->back();
            }
            
            if ($totalQuantity > 9) {
                $this->toast('The total quantity for a single order should not exceed 9 items. For 10 or more items, please place a bulk order.', 'error');
                return redirect()->back();
            }

            $additionalPaymentRequired = floatval($request->input('additional_payment_required', 0));
            if ($additionalPaymentRequired > 0) {
                session([
                    'order_confirmation_data' => $request->all(),
                    'confirmation_type' => 'single_custom'
                ]);
                
                return redirect()->route('customer.payment.methods', [
                    'order_id' => $order->order_id,
                    'additional_payment' => $additionalPaymentRequired
                ]);
            }

            DB::beginTransaction();
            try {
                CustomizationDetails::where('order_ID', $order->order_id)->delete();
                
                foreach ($request->rows as $row) {
                    if (!empty($row['name']) && !empty($row['size'])) {
                        CustomizationDetails::create([
                            'customization_details_ID' => uniqid(),
                            'order_ID' => $order->order_id,
                            'sizes_ID' => $row['size'],
                            'name' => $row['name'],
                            'remarks' => $row['remarks'] ?? null,
                            'quantity' => 1,
                        ]);
                    }
                }

                $unitPrice = $order->quantity > 0 ? ($order->final_price / $order->quantity) : 0;
                
                $order->quantity = $totalQuantity;
                $order->final_price = $unitPrice * $totalQuantity;
                $order->token = null;
                $order->save();
                
                \App\Models\Notification::create([
                    'user_id' => $order->productionCompany->user_id,
                    'message' => 'Single item customization details submitted for order #' . $order->order_id,
                    'is_read' => false,
                    'order_id' => $order->order_id,
                ]);
                
                DB::commit();
                
                Log::info('Order updated during single custom confirmation', [
                    'order_id' => $order->order_id,
                    'new_quantity' => $totalQuantity,
                    'new_price' => $order->final_price,
                    'user_id' => Auth::id()
                ]);

                $this->toast('Customization details submitted successfully!', 'success');
                return redirect()->route('home');
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error in confirmSingleCustomPost transaction: ' . $e->getMessage(), [
                    'exception' => $e,
                    'order_id' => $order->order_id
                ]);
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Error in confirmSingleCustomPost: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            $this->toast('An error occurred while submitting customization details.', 'error');
            return redirect()->back();
        }
    }
    
    /**
     * Process an order after additional payment has been made.
     * This method is called after the payment proof has been uploaded.
     */
    public function processOrderAfterPayment(Request $request)
    {
        try {
            // Validate basic information
            $request->validate([
                'order_id' => 'required|exists:orders,order_id',
                'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);
            
            // Retrieve order
            $order = Order::findOrFail($request->order_id);
            
            // Retrieve stored order data from session
            $orderData = session('order_confirmation_data');
            $confirmationType = session('confirmation_type');
            
            if (!$orderData) {
                $this->toast('Order data not found. Please try again.', 'error');
                return redirect()->route('home');
            }
            
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            $payment = new \App\Models\Payment([
                'order_id' => $order->order_id,
                'amount' => $request->input('amount', 0),
                'payment_proof' => $paymentProofPath,
                'user_id' => Auth::id(),
                'payment_date' => now(),
                'status' => 'completed',
                'payment_type' => 'additional_payment'
            ]);
            $payment->save();
            
            switch ($confirmationType) {
                case 'bulk_custom':
                    return $this->processBulkCustomAfterPayment($order, $orderData);
                case 'jersey_bulk_custom':
                    return $this->processJerseyBulkCustomAfterPayment($order, $orderData);
                case 'single_custom':
                    return $this->processSingleCustomAfterPayment($order, $orderData);
                default:
                    $this->toast('Unknown order confirmation type.', 'error');
                    return redirect()->route('home');
            }
        } catch (\Exception $e) {
            Log::error('Error in processOrderAfterPayment: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            $this->toast('An error occurred while processing your order after payment.', 'error');
            return redirect()->route('home');
        }
    }
    
    /**
     * Process bulk custom order after payment
     */
    private function processBulkCustomAfterPayment($order, $orderData)
    {
        DB::beginTransaction();
        try {
            // Clear any existing customization details for this order
            CustomizationDetails::where('order_ID', $order->order_id)->delete();
            
            $totalQuantity = 0;
            
            // Create new customization details
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
            
            // Calculate unit price based on original order
            $unitPrice = $order->quantity > 0 ? ($order->final_price / $order->quantity) : 0;
            
            // Update order quantities and prices
            $order->quantity = $totalQuantity;
            $order->final_price = $unitPrice * $totalQuantity;
            $order->token = null;
            $order->save();
            
            // Create notification for production company/printer
            \App\Models\Notification::create([
                'user_id' => $order->productionCompany->user_id,
                'message' => 'Additional payment received and bulk customization details submitted for order #' . $order->order_id,
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);
            
            DB::commit();
            
            // Clear session data
            session()->forget(['order_confirmation_data', 'confirmation_type']);
            
            // Log successful order update
            Log::info('Order updated after payment for bulk custom confirmation', [
                'order_id' => $order->order_id,
                'new_quantity' => $totalQuantity,
                'new_price' => $order->final_price,
                'user_id' => Auth::id()
            ]);
            
            $this->toast('Payment received and customization details submitted successfully!', 'success');
            return redirect()->route('home');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in processBulkCustomAfterPayment: ' . $e->getMessage(), [
                'exception' => $e,
                'order_id' => $order->order_id
            ]);
            $this->toast('An error occurred while processing your order after payment.', 'error');
            return redirect()->route('home');
        }
    }
    
    /**
     * Process jersey bulk custom order after payment
     */
    private function processJerseyBulkCustomAfterPayment($order, $orderData)
    {
        DB::beginTransaction();
        try {
            // Clear any existing customization details for this order
            CustomizationDetails::where('order_ID', $order->order_id)->delete();
            
            $totalQuantity = 0;
            
            // Create new customization details
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
            
            // Calculate unit price based on original order
            $unitPrice = $order->quantity > 0 ? ($order->final_price / $order->quantity) : 0;
            
            // Update order quantities and prices
            $order->quantity = $totalQuantity;
            $order->final_price = $unitPrice * $totalQuantity;
            $order->token = null;
            $order->save();
            
            // Create notification for production company/printer
            \App\Models\Notification::create([
                'user_id' => $order->productionCompany->user_id,
                'message' => 'Additional payment received and jersey customization details submitted for order #' . $order->order_id,
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);
            
            DB::commit();
            
            // Clear session data
            session()->forget(['order_confirmation_data', 'confirmation_type']);
            
            // Log successful order update
            Log::info('Order updated after payment for jersey bulk custom confirmation', [
                'order_id' => $order->order_id,
                'new_quantity' => $totalQuantity,
                'new_price' => $order->final_price,
                'user_id' => Auth::id()
            ]);
            
            $this->toast('Payment received and jersey customization details submitted successfully!', 'success');
            return redirect()->route('home');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in processJerseyBulkCustomAfterPayment: ' . $e->getMessage(), [
                'exception' => $e,
                'order_id' => $order->order_id
            ]);
            $this->toast('An error occurred while processing your order after payment.', 'error');
            return redirect()->route('home');
        }
    }
    
    /**
     * Process single custom order after payment
     */
    private function processSingleCustomAfterPayment($order, $orderData)
    {
        DB::beginTransaction();
        try {
            // Clear any existing customization details for this order
            CustomizationDetails::where('order_ID', $order->order_id)->delete();
            
            $totalQuantity = 0;
            
            // Create new customization details
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
            
            // Calculate unit price based on original order
            $unitPrice = $order->quantity > 0 ? ($order->final_price / $order->quantity) : 0;
            
            // Update order quantities and prices
            $order->quantity = $totalQuantity;
            $order->final_price = $unitPrice * $totalQuantity;
            $order->token = null;
            $order->save();
            
            // Create notification for production company/printer
            \App\Models\Notification::create([
                'user_id' => $order->productionCompany->user_id,
                'message' => 'Additional payment received and single customization details submitted for order #' . $order->order_id,
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);
            
            DB::commit();
            
            // Clear session data
            session()->forget(['order_confirmation_data', 'confirmation_type']);
            
            // Log successful order update
            Log::info('Order updated after payment for single custom confirmation', [
                'order_id' => $order->order_id,
                'new_quantity' => $totalQuantity,
                'new_price' => $order->final_price,
                'user_id' => Auth::id()
            ]);
            
            $this->toast('Payment received and customization details submitted successfully!', 'success');
            return redirect()->route('home');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in processSingleCustomAfterPayment: ' . $e->getMessage(), [
                'exception' => $e,
                'order_id' => $order->order_id
            ]);
            $this->toast('An error occurred while processing your order after payment.', 'error');
            return redirect()->route('home');
        }
    }
}