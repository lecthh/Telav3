<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class DesignerOrderController extends Controller
{

    public function dashboard()
    {
        $designer = session('admin');
        $assignedOrdersCount = 0;
        $completedOrdersCount = 0;

        $assignedOrdersCount = Order::where('assigned_designer_id', $designer->designer_id)
            ->where('status_id', '>=', 2)
            ->where('status_id', '!=', 7)
            ->count();


        $completedOrdersCount = Order::where('assigned_designer_id', $designer->designer_id)
            ->where('status_id', 7)
            ->count();

        return view('partner.designer.dashboard', compact('assignedOrdersCount', 'completedOrdersCount'));
    }

    public function cancelDesignAssignment($order_id)
    {
        $order = Order::find($order_id);
        $order->assigned_designer_id = null;
        $order->status_id = 1;
        $order->save();
        return redirect()->route('designer-dashboard')->with('success', 'Design assignment cancelled successfully!');
    }


    public function index()
    {
        $designer = session('admin');
        $assignedOrders = Order::where('assigned_designer_id', $designer->designer_id)
            ->where('status_id', '>=', 2)
            ->where('status_id', '!=', 7)
            ->get();

        return view('partner.designer.orders', compact('assignedOrders'));
    }

    public function assignedOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.designer.order', compact('order'));
    }

    public function assignedOrderPost(Request $request, $order_id)
    {
        $request->validate([
            'vacancyImageFiles' => 'required',
            'vacancyImageFiles.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
        ]);

        $order = Order::findOrFail($order_id);

        if ($request->hasFile('vacancyImageFiles')) {
            foreach ($request->file('vacancyImageFiles') as $file) {
                $filePath = $file->store('order_images', 'public');
                OrderImages::create([
                    'order_id' => $order->order_id,
                    'image' => $filePath,
                    'status_id' => 2,
                ]);
            }
        }
        $order->status_id = 3;
        $order->save();

        $user_id = $order->user->user_id;

        Notification::create([
            'user_id' => $user_id,
            'message' => 'Finalize Order',
            'is_read' => false,
            'order_id' => $order->order_id,
        ]);

        $designer = $order->designer->user->name;
        $token = uniqid();
        $user = $order->user;

        if ($order->is_bulk_order) {
            if (!$order->is_customized) {
                $url = URL::temporarySignedRoute(
                    'confirm-bulk',
                    now()->addMinutes(60),
                    ['token' => $token, 'email' => $user->email, 'order_id' => $order->order_id]
                );
            } else if ($order->is_customized && $order->apparelType->id != 1) {
                $url = URL::temporarySignedRoute(
                    'confirm-bulk-custom',
                    now()->addMinutes(60),
                    ['token' => $token, 'email' => $user->email, 'order_id' => $order->order_id]
                );
            } else if ($order->is_customized && $order->apparelType->id == 1) {

                $url = URL::temporarySignedRoute(
                    'confirm-jerseybulk-custom',
                    now()->addMinutes(60),
                    ['token' => $token, 'email' => $user->email, 'order_id' => $order->order_id]
                );
            }
        }
        $name = $user->name;
        $order->update(['token' => $token]);
        $order->save();
        Mail::send('mail.confirmationLink', ['url' => $url, 'name' => $name, 'Designer' => $designer], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Order Is Confirmed');
        });

        return redirect()->route('partner.designer.orders')->with('success', 'Designs uploaded and order finalized successfully!');
    }

    public function complete()
    {
        $designer = session('admin');
        $orders = Order::where('assigned_designer_id', $designer->designer_id)
            ->where('status_id', '=', 7)
            ->get();
        return view('partner.designer.complete.orders-complete', compact('orders'));
    }

    public function completeOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.designer.complete.order', compact('order'));
    }
}
