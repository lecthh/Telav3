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
                $this->toast('Invalid token or order.', 'error');
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
                'rows.*.jerseyNo' => 'required|integer',
                'rows.*.topSize' => 'required|integer',
                'rows.*.shortSize' => 'required|integer',
                'rows.*.hasPocket' => 'nullable|boolean',
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
                return !empty($row['name']) && !empty($row['topSize']) && !empty($row['shortSize']);
            }));

            if ($totalQuantity < 10) {
                $this->toast('You must have at least 10 customization entries.', 'error');
                return redirect()->back();
            }

            foreach ($validatedData['rows'] as $row) {
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

            $order->token = null;
            $order->save();
            
            // Notification for production company/printer
            \App\Models\Notification::create([
                'user_id' => $order->productionCompany->user_id,
                'message' => 'Jersey customization details submitted for order #' . $order->order_id,
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $this->toast('Jersey customization details submitted successfully!', 'success');
            return redirect()->route('home');
        } catch (\Exception $e) {
            $this->toast('An error occurred while submitting jersey customization details.', 'error');
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
