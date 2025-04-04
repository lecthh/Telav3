<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\Toastable;
use Illuminate\Support\Facades\Log;

class OrderProduceController extends Controller {
    use Toastable;

    //PENDING
    public function pending()
    {
        $productionCompany = session('admin');
        $productionCompanyId = null;
        
        if (is_object($productionCompany) && isset($productionCompany->id)) {
            $productionCompanyId = $productionCompany->id;
        } elseif (is_array($productionCompany) && isset($productionCompany['App\\Models\\ProductionCompany'])) {
            $productionCompanyId = $productionCompany['App\\Models\\ProductionCompany']['id'];
        } elseif (is_object($productionCompany) && property_exists($productionCompany, 'App\\Models\\ProductionCompany')) {
            $pcData = $productionCompany->{'App\\Models\\ProductionCompany'};
            $productionCompanyId = $pcData->id ?? ($pcData['id'] ?? null);
        }
        
        $pendingOrders = Order::where('status_id', '1')
            ->where('production_company_id', $productionCompanyId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        Log::info('Pending orders', [
            'count' => $pendingOrders->count(),
            'production_company_id' => $productionCompanyId
        ]);
        
        return view('partner.printer.orders', compact('pendingOrders'));
    }

    public function pendingOrder($order_id)
    {
        $order = Order::find($order_id);
        $designers = Designer::all();
        return view('partner.printer.order', compact('order', 'designers'));
    }

    //DESIGN IN PROGRESS
    public function designInProgress()
    {
        $productionCompany = session('admin');
        
        Log::info('Design In Progress - Session Admin Data', [
            'admin_session' => $productionCompany,
            'user_id' => auth()->id(),
            'auth_check' => auth()->check()
        ]);
        
        $allInProgressOrders = Order::where('status_id', '2')->get();
        Log::info('All design in progress orders', [
            'count' => $allInProgressOrders->count(),
            'orders' => $allInProgressOrders->toArray()
        ]);
        
        $productionCompanyId = null;
        
        if (is_object($productionCompany) && isset($productionCompany->id)) {
            $productionCompanyId = $productionCompany->id;
        } elseif (is_array($productionCompany) && isset($productionCompany['App\\Models\\ProductionCompany'])) {
            $productionCompanyId = $productionCompany['App\\Models\\ProductionCompany']['id'];
        } elseif (is_object($productionCompany) && property_exists($productionCompany, 'App\\Models\\ProductionCompany')) {
            $pcData = $productionCompany->{'App\\Models\\ProductionCompany'};
            $productionCompanyId = $pcData->id ?? ($pcData['id'] ?? null);
        }
        
        Log::info('Extracted production company ID', [
            'id' => $productionCompanyId
        ]);
        
        $orders = Order::where('status_id', '2')
            ->where('production_company_id', $productionCompanyId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        Log::info('Filtered design in progress orders', [
            'count' => $orders->count(),
            'production_company_id' => $productionCompanyId
        ]);
        
        return view('partner.printer.design.orders-design', compact('orders'));
    }

    public function designOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.design.order', compact('order'));
    }

    //FINALIZE ORDER
    public function finalize()
    {
        $productionCompany = session('admin');
        $productionCompanyId = null;
        
        if (is_object($productionCompany) && isset($productionCompany->id)) {
            $productionCompanyId = $productionCompany->id;
        } elseif (is_array($productionCompany) && isset($productionCompany['App\\Models\\ProductionCompany'])) {
            $productionCompanyId = $productionCompany['App\\Models\\ProductionCompany']['id'];
        } elseif (is_object($productionCompany) && property_exists($productionCompany, 'App\\Models\\ProductionCompany')) {
            $pcData = $productionCompany->{'App\\Models\\ProductionCompany'};
            $productionCompanyId = $pcData->id ?? ($pcData['id'] ?? null);
        }
        
        $finalizeOrders = Order::where('status_id', '3')
            ->where('production_company_id', $productionCompanyId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        \Log::info('Finalize orders', [
            'count' => $finalizeOrders->count(),
            'production_company_id' => $productionCompanyId
        ]);
        
        $orders = $finalizeOrders;
        
        return view('partner.printer.finalize.orders-finalize', compact('orders'));
    }

    public function finalizeOrder($order_id)
    {
        $order = Order::find($order_id);

        $customizationDetails = $order->customizationDetails()->get();

        if ($customizationDetails->isEmpty()) {
            $customizationDetails = null;
        }

        return view('partner.printer.finalize.order', compact('order', 'customizationDetails'));
    }

    public function finalizeOrderPost($order_id)
    {
        try {
            $order = Order::findOrFail($order_id);

            foreach ($order->imagesWithStatusTwo as $image) {
                $image->update(['status_id' => 4]);
            }

            Notification::create([
                'user_id' => $order->user->user_id,
                'message' => 'Your Order Is Waiting To Be Printed',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $order->update(['status_id' => 4]);

            $this->toast('Order finalized and waiting for printing!', 'success');
            return redirect()->route('partner.printer.awaiting-printing');
        } catch (\Exception $e) {
            Log::error('Finalize Order Error: ' . $e->getMessage());
            $this->toast('An error occurred while finalizing the order.', 'error');
            return redirect()->back();
        }
    }

    //AWAITING ORDER
    public function awaitingPrinting()
    {
        $productionCompany = session('admin');
        $productionCompanyId = null;
        
        if (is_object($productionCompany) && isset($productionCompany->id)) {
            $productionCompanyId = $productionCompany->id;
        } elseif (is_array($productionCompany) && isset($productionCompany['App\\Models\\ProductionCompany'])) {
            $productionCompanyId = $productionCompany['App\\Models\\ProductionCompany']['id'];
        } elseif (is_object($productionCompany) && property_exists($productionCompany, 'App\\Models\\ProductionCompany')) {
            $pcData = $productionCompany->{'App\\Models\\ProductionCompany'};
            $productionCompanyId = $pcData->id ?? ($pcData['id'] ?? null);
        }
        
        $awaitingPrinting = Order::where('status_id', '4')
            ->where('production_company_id', $productionCompanyId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        \Log::info('Awaiting printing orders', [
            'count' => $awaitingPrinting->count(),
            'production_company_id' => $productionCompanyId
        ]);
        
        $orders = $awaitingPrinting;
        
        return view('partner.printer.awaiting.orders-awaiting', compact('orders'));
    }

    public function awaitingOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.awaiting.order', compact('order'));
    }

    public function awaitingOrderPost(Request $request, $order_id)
    {
        try {
            $request->validate([
                'eta' => 'required|date|after:today',
            ]);

            $order = Order::findOrFail($order_id);
            $order->status_id = 5;
            $order->eta = $request->eta;
            $order->save();

            Notification::create([
                'user_id'  => $order->user->user_id,
                'message'  => 'Your Order Is Being Printed. Expected completion date: ' . date('F j, Y', strtotime($request->eta)),
                'is_read'  => false,
                'order_id' => $order->order_id,
            ]);


            $this->toast('Order status updated successfully!', 'success');

            return redirect()->route('partner.printer.printing-in-progress');
        } catch (\Exception $e) {

            $this->toast('Error updating order status: ' . $e->getMessage(), 'error');

            return redirect()->back();
        }
    }

    //PRINTING IN PROGRESS
    public function printingInProgress()
    {
        $productionCompany = session('admin');
        $productionCompanyId = null;
        
        if (is_object($productionCompany) && isset($productionCompany->id)) {
            $productionCompanyId = $productionCompany->id;
        } elseif (is_array($productionCompany) && isset($productionCompany['App\\Models\\ProductionCompany'])) {
            $productionCompanyId = $productionCompany['App\\Models\\ProductionCompany']['id'];
        } elseif (is_object($productionCompany) && property_exists($productionCompany, 'App\\Models\\ProductionCompany')) {
            $pcData = $productionCompany->{'App\\Models\\ProductionCompany'};
            $productionCompanyId = $pcData->id ?? ($pcData['id'] ?? null);
        }
        
        $printingInProgress = Order::where('status_id', '5')
            ->where('production_company_id', $productionCompanyId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        \Log::info('Printing in progress orders', [
            'count' => $printingInProgress->count(),
            'production_company_id' => $productionCompanyId
        ]);
        
        $orders = $printingInProgress;
        
        return view('partner.printer.printing.orders-printing', compact('orders'));
    }

    public function printingOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.printing.order', compact('order'));
    }

    public function printingOrderPost($order_id)
    {
        try {
            $order = Order::findOrFail($order_id);
            $order->update(['status_id' => 6]);

            Notification::create([
                'user_id' => $order->user->user_id,
                'message' => 'Your Order Is Ready to be Collected/Delivered',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $this->toast('Order marked as ready for collection/delivery!', 'success');
            return redirect()->route('partner.printer.ready');
        } catch (\Exception $e) {
            Log::error('Printing Order Update Error: ' . $e->getMessage());
            $this->toast('An error occurred while updating the order status.', 'error');
            return redirect()->back();
        }
    }

    //READY
    public function ready()
    {
        $productionCompany = session('admin');
        $productionCompanyId = null;
        
        if (is_object($productionCompany) && isset($productionCompany->id)) {
            $productionCompanyId = $productionCompany->id;
        } elseif (is_array($productionCompany) && isset($productionCompany['App\\Models\\ProductionCompany'])) {
            $productionCompanyId = $productionCompany['App\\Models\\ProductionCompany']['id'];
        } elseif (is_object($productionCompany) && property_exists($productionCompany, 'App\\Models\\ProductionCompany')) {
            $pcData = $productionCompany->{'App\\Models\\ProductionCompany'};
            $productionCompanyId = $pcData->id ?? ($pcData['id'] ?? null);
        }
        
        $readyOrders = Order::where('status_id', '6')
            ->where('production_company_id', $productionCompanyId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        \Log::info('Ready for collection orders', [
            'count' => $readyOrders->count(),
            'production_company_id' => $productionCompanyId
        ]);
        
        $orders = $readyOrders;
        
        return view('partner.printer.ready.orders-ready', compact('orders'));
    }
    public function readyOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.ready.order', compact('order'));
    }

    public function readyOrderPost($order_id)
    {
        try {
            $order = Order::findOrFail($order_id);
            $order->update(['status_id' => 7]);

            Notification::create([
                'user_id' => $order->user->user_id,
                'message' => 'Your Order is Completed',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $this->toast('Order marked as completed!', 'success');
            return redirect()->route('partner.printer.completed');
        } catch (\Exception $e) {
            Log::error('Ready Order Update Error: ' . $e->getMessage());
            $this->toast('An error occurred while completing the order.', 'error');
            return redirect()->back();
        }
    }

    //COMPLETE OR CANCEL
    public function cancelOrder($order_id)
    {
        try {
            $order = Order::findOrFail($order_id);
            $order->update(['status_id' => 8]);

            Notification::create([
                'user_id' => $order->user->user_id,
                'message' => 'Your Order Has Been Cancelled',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $this->toast('Order cancelled successfully!', 'success');
            return redirect()->route('printer-dashboard');
        } catch (\Exception $e) {
            Log::error('Cancel Order Error: ' . $e->getMessage());
            $this->toast('An error occurred while canceling the order.', 'error');
            return redirect()->back();
        }
    }

    public function completed()
    {
        $productionCompany = session('admin');
        $productionCompanyId = null;
        
        if (is_object($productionCompany) && isset($productionCompany->id)) {
            $productionCompanyId = $productionCompany->id;
        } elseif (is_array($productionCompany) && isset($productionCompany['App\\Models\\ProductionCompany'])) {
            $productionCompanyId = $productionCompany['App\\Models\\ProductionCompany']['id'];
        } elseif (is_object($productionCompany) && property_exists($productionCompany, 'App\\Models\\ProductionCompany')) {
            $pcData = $productionCompany->{'App\\Models\\ProductionCompany'};
            $productionCompanyId = $pcData->id ?? ($pcData['id'] ?? null);
        }
        
        $completedOrders = Order::where('status_id', '7')
            ->where('production_company_id', $productionCompanyId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        \Log::info('Completed orders', [
            'count' => $completedOrders->count(),
            'production_company_id' => $productionCompanyId
        ]);
        
        $orders = $completedOrders;
        
        return view('partner.printer.complete.orders-complete', compact('orders'));
    }
    public function completedOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.complete.order', compact('order'));
    }

    //ASSIGN DESIGNER
    public function assignDesigner(Request $request, $order_id)
    {
        try {
            $validatedData = $request->validate([
                'selected_designer_id' => 'required|integer|exists:designers,designer_id',
            ]);
            
            $order = Order::findOrFail($order_id);
            $designerId = intval($validatedData['selected_designer_id']);
            $order->update([
                'assigned_designer_id' => $designerId,
                'status_id' => 2,
            ]);

            // Notify customer that design is in progress
            Notification::create([
                'user_id' => $order->user->user_id,
                'message' => 'Design in Progress',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);
            
            // Notify designer about the new job
            $designer = Designer::with('user')->find($designerId);
            if ($designer && $designer->user) {
                Notification::create([
                    'user_id' => $designer->user->user_id,
                    'message' => 'New design job assigned to you: Order #' . $order->order_id,
                    'is_read' => false,
                    'order_id' => $order->order_id,
                ]);
            }

            $this->toast('Designer assigned successfully!', 'success');
            return redirect()->route('partner.printer.orders');
        } catch (\Exception $e) {
            Log::error('Assign Designer Error: ' . $e->getMessage());
            $this->toast('An error occurred while assigning the designer.', 'error');
            return redirect()->back();
        }
    }
}