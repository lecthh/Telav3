<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\Notification;
use App\Models\Order;
use App\Traits\Toastable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PendingRequestController extends Controller
{
    use Toastable;
    public function index()
    {
        $pendingOrders = Order::where('status_id', '1')->get();
        return view('partner.printer.orders', compact('pendingOrders'));
    }

    public function pendingOrder($order_id)
    {
        $order = Order::find($order_id);
        $designers = Designer::all();
        return view('partner.printer.order', compact('order', 'designers'));
    }
    // Create/update notification here
    public function assignDesigner(Request $request, $order_id)
    {
        try {
            $validatedData = $request->validate([
                'selected_designer_id' => 'required|integer|exists:users,user_id',
            ]);

            $order = Order::findOrFail($order_id);
            $order->update([
                'assigned_designer_id' => intval($validatedData['selected_designer_id']),
                'status_id' => 2,
            ]);

            Notification::create([
                'user_id' => $order->user->user_id,
                'message' => 'Design in Progress',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $this->toast('Designer assigned successfully!', 'success');
            return redirect()->route('partner.printer.orders');
        } catch (\Exception $e) {
            Log::error('Assign Designer Error: ' . $e->getMessage());
            $this->toast('An error occurred while assigning the designer.', 'error');
            return redirect()->back();
        }
    }
}
