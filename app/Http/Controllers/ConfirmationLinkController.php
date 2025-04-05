<?php

namespace App\Http\Controllers;

use App\Models\CustomizationDetails;
use App\Models\Order;
use App\Models\Sizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Toastable;

class ConfirmationLinkController extends Controller
{
    use Toastable;
    public function confirmBulkCustom(Request $request, $token)
    {
        // Fetch order by token
        $order = Order::where('token', $token)->firstOrFail();

        // Check if there's imported customizations data from Excel
        $importedCustomizations = session('imported_customizations');
        
        // Log information for debugging
        \Illuminate\Support\Facades\Log::info('confirmBulkCustom', [
            'has_imported_data' => !empty($importedCustomizations),
            'imported_count' => is_array($importedCustomizations) ? count($importedCustomizations) : 0,
            'sample_data' => !empty($importedCustomizations) ? $importedCustomizations[0] : null
        ]);
        
        if (!empty($importedCustomizations)) {
            // Use imported customization data
            $rows = $importedCustomizations;
            
            // Another log to ensure we're setting the rows correctly
            \Illuminate\Support\Facades\Log::info('Using imported rows', [
                'count' => count($rows),
                'first_row' => $rows[0] ?? null
            ]);
        } else {
            // Use default or old input
            $rows = old('rows', array_fill(0, 10, ['name' => '', 'size' => '', 'remarks' => '']));
            
            \Illuminate\Support\Facades\Log::info('Using default rows', [
                'count' => count($rows)
            ]);
        }

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

            foreach ($request->rows as $row) {
                CustomizationDetails::create([
                    'customization_details_ID' => uniqid(),
                    'order_ID' => $order->order_id,
                    'sizes_ID' => $row['size'],
                    'name' => $row['name'],
                    'remarks' => $row['remarks'] ?? null,
                    'quantity' => 1,
                ]);
            }

            $order->token = null;
            $order->save();
            
            // Notification for production company/printer
            \App\Models\Notification::create([
                'user_id' => $order->productionCompany->user_id,
                'message' => 'Bulk customization details submitted for order #' . $order->order_id,
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $this->toast('Customization details submitted successfully!', 'success');
            return redirect()->route('home');
        } catch (\Exception $e) {
            $this->toast('An error occurred while submitting customization details.', 'error');
            return redirect()->back();
        }
    }

    public function confirmJerseyBulkCustom(Request $request, $token)
    {
        try {
            // Fetch order by token
            $order = Order::where('token', $token)->first();

            if (!$order) {
                // Log the token validation failure
                \Illuminate\Support\Facades\Log::info('Jersey form access - Invalid token', [
                    'token' => $token,
                    'user_ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
                
                // Check if this token was already used (find by order without token)
                $completedOrder = Order::where(function($query) use ($token) {
                    $query->whereNull('token')
                          ->where('custom_design_info', 'like', '%Jersey order form completed%');
                })->first();
                
                if ($completedOrder) {
                    $this->toast('This jersey customization form has already been completed successfully.', 'info');
                } else {
                    $this->toast('Invalid token or order.', 'error');
                }
                
                return redirect()->route('home');
            }

            // Check if there's imported jersey details from Excel
            $importedJerseys = session('imported_jerseys');
            
            if ($importedJerseys) {
                // Use imported jersey data
                $rows = $importedJerseys;
            } else {
                // Use default or old input
                $rows = old('rows', array_fill(0, 10, [
                    'name' => '',
                    'jerseyNo' => '',
                    'topSize' => '',
                    'shortSize' => '',
                    'hasPocket' => false,
                    'remarks' => ''
                ]));
            }

            $sizes = Sizes::all();

            return view('customer.order-confirmation.jersey-bulk-customized', compact('order', 'rows', 'sizes'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Jersey form error: ' . $e->getMessage(), [
                'token' => $token,
                'exception' => $e->getTraceAsString()
            ]);
            $this->toast('An error occurred while confirming the jersey customization: ' . $e->getMessage(), 'error');
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
                'rows.*.jerseyNo' => 'required|string',  // Changed from integer to string
                'rows.*.topSize' => 'required|integer',
                'rows.*.shortSize' => 'required|integer',
                'rows.*.hasPocket' => 'nullable|boolean',
                'rows.*.remarks' => 'nullable|string',
                'new_total_price' => 'nullable|numeric',
                'new_quantity' => 'nullable|integer',
                'additional_payment' => 'nullable|numeric',
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
            
            // Check if additional payment is required (more jerseys than originally ordered)
            if ($totalQuantity > $order->quantity) {
                // Calculate additional payment amount
                $unitPrice = $order->final_price / $order->quantity;
                $additionalQuantity = $totalQuantity - $order->quantity;
                $additionalPaymentAmount = ($additionalQuantity * $unitPrice) / 2; // 50% down payment
                
                \Illuminate\Support\Facades\Log::info('Additional payment required for jersey order', [
                    'order_id' => $order->order_id,
                    'original_quantity' => $order->quantity,
                    'new_quantity' => $totalQuantity,
                    'additional_quantity' => $additionalQuantity,
                    'unit_price' => $unitPrice,
                    'amount' => $additionalPaymentAmount
                ]);
                
                // Save the jersey details to session temporarily
                session(['temp_jersey_details' => $validatedData['rows']]);
                
                // Redirect to the additional payment page
                $this->toast('Additional payment required for extra jerseys.', 'warning');
                return redirect()->route('order.additional-payment', [
                    'order_id' => $order->order_id,
                    'amount' => $additionalPaymentAmount,
                    'quantity' => $additionalQuantity
                ]);
            }

            // Debug SQL Query
            \Illuminate\Support\Facades\Log::info('Starting Jersey details creation', [
                'order_id' => $order->order_id,
                'rows_count' => count($validatedData['rows']),
                'filtered_count' => $totalQuantity
            ]);

            // First clean up any existing entries for this order (if resubmitting)
            try {
                \App\Models\CustomizationDetails::where('order_ID', $order->order_id)->delete();
                \Illuminate\Support\Facades\Log::info('Cleaned up existing customization details');
            } catch (\Exception $deleteEx) {
                \Illuminate\Support\Facades\Log::error('Error cleaning up: ' . $deleteEx->getMessage());
            }

            $insertedCount = 0;
            foreach ($validatedData['rows'] as $row) {
                try {
                    // Print out the full row data for this item to see what fields might be causing issues
                    \Illuminate\Support\Facades\Log::info('Processing row data:', [
                        'row_data' => $row
                    ]);
                    
                    // CRITICAL FIX: We need to set the 'number' field as required by the database schema
                    $detail = CustomizationDetails::create([
                        'customization_details_ID' => uniqid(),
                        'order_ID' => $order->order_id,
                        'name' => $row['name'],
                        'jersey_number' => $row['jerseyNo'],
                        'number' => $row['jerseyNo'],  // ADDED THIS: Set 'number' field from jerseyNo
                        'sizes_ID' => $row['topSize'],
                        'short_size' => $row['shortSize'],
                        'has_pocket' => isset($row['hasPocket']) ? (bool) $row['hasPocket'] : false,
                        'remarks' => $row['remarks'] ?? null,
                        'quantity' => 1,
                    ]);
                    $insertedCount++;
                    
                    \Illuminate\Support\Facades\Log::info('Created jersey entry ' . $insertedCount, [
                        'id' => $detail->customization_details_ID,
                        'name' => $row['name'],
                        'jersey_number' => $row['jerseyNo'],
                        'number' => $row['jerseyNo'] // Log this field too
                    ]);
                } catch (\Exception $rowEx) {
                    \Illuminate\Support\Facades\Log::error('Error creating row: ' . $rowEx->getMessage(), [
                        'name' => $row['name'] ?? 'unknown',
                        'topSize' => $row['topSize'] ?? 'unknown',
                        'shortSize' => $row['shortSize'] ?? 'unknown'
                    ]);
                }
            }

            // Verify data was saved
            $count = \App\Models\CustomizationDetails::where('order_ID', $order->order_id)->count();
            \Illuminate\Support\Facades\Log::info('Final customization count: ' . $count . ' for order ' . $order->order_id);

            // Store the production company user_id before nullifying the token
            $productionCompanyUserId = $order->productionCompany->user_id;
            $orderId = $order->order_id;
            
            // If quantity has changed, update the order quantity and price
            if (!empty($request->new_quantity) && $request->new_quantity > $order->quantity) {
                $originalQuantity = $order->quantity;
                $newQuantity = $request->new_quantity;
                
                \Illuminate\Support\Facades\Log::info('Updating order quantity', [
                    'order_id' => $orderId,
                    'original_quantity' => $originalQuantity,
                    'new_quantity' => $newQuantity
                ]);
                
                // Update the order quantity and price
                if (!empty($request->new_total_price)) {
                    $order->final_price = $request->new_total_price;
                }
                $order->quantity = $newQuantity;
            }
            
            // Mark the order as confirmed by nullifying the token
            $order->token = null;
            $order->is_customized = true;
            
            // Add a note in custom_design_info
            if ($order->custom_design_info) {
                $order->custom_design_info .= ' [Jersey order form completed]';
            } else {
                $order->custom_design_info = '[Jersey order form completed]';
            }
            
            $order->save();
            
            // Additional backup direct SQL update to ensure changes are saved
            try {
                \Illuminate\Support\Facades\DB::statement("
                    UPDATE orders 
                    SET 
                        token = NULL,
                        is_customized = 1,
                        custom_design_info = CONCAT(IFNULL(custom_design_info, ''), ' [Jersey order form completed]')
                    WHERE order_id = ?
                ", [$orderId]);
            } catch (\Exception $dbEx) {
                \Illuminate\Support\Facades\Log::error('DB Update Error: ' . $dbEx->getMessage());
                // Continue even if SQL update fails, since we already saved the model
            }
            
            \Illuminate\Support\Facades\Log::alert('JERSEY ORDER FORM COMPLETED', [
                'order_id' => $orderId,
                'action' => 'Form completed, token nullified, order ready for processing',
                'saved_entries' => $insertedCount,
                'final_status' => 'Success'
            ]);
            
            // Notification for production company/printer
            try {
                \App\Models\Notification::create([
                    'user_id' => $productionCompanyUserId,
                    'message' => 'Jersey customization details submitted for order #' . $orderId,
                    'is_read' => false,
                    'order_id' => $orderId,
                ]);
            } catch (\Exception $notifEx) {
                \Illuminate\Support\Facades\Log::error('Notification Error: ' . $notifEx->getMessage());
                // Continue even if notification creation fails
            }

            // Clear session data to avoid confusion on subsequent form submissions
            session()->forget(['imported_jerseys', 'temp_jersey_details']);
            
            $this->toast('Jersey customization details submitted successfully! Your order is now ready to be processed.', 'success');
            return redirect()->route('home');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Jersey form submit error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->toast('An error occurred while submitting jersey customization details: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
    
    public function confirmSingleCustom(Request $request, $token)
    {
        $order = Order::where('order_id', $request->order_id)
            ->where('token', $token)
            ->firstOrFail();

        // Just use one row for single customized order
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

            foreach ($request->rows as $row) {
                CustomizationDetails::create([
                    'customization_details_ID' => uniqid(),
                    'order_ID' => $order->order_id,
                    'sizes_ID' => $row['size'],
                    'name' => $row['name'],
                    'remarks' => $row['remarks'] ?? null,
                    'quantity' => 1,
                ]);
            }

            $order->token = null;
            $order->save();
            
            // Notification for production company/printer
            \App\Models\Notification::create([
                'user_id' => $order->productionCompany->user_id,
                'message' => 'Single item customization details submitted for order #' . $order->order_id,
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $this->toast('Customization details submitted successfully!', 'success');
            return redirect()->route('home');
        } catch (\Exception $e) {
            $this->toast('An error occurred while submitting customization details.', 'error');
            return redirect()->back();
        }
    }
}
