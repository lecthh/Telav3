<?php

namespace App\Http\Controllers;

use App\Models\CustomizationDetails;
use App\Models\Order;
use App\Models\Sizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfirmationLinkController extends Controller
{
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
            return redirect()->back()->withErrors('You are not authorized to confirm this order.');
        }

        $totalQuantity = count(array_filter($validatedData['rows'], function ($row) {
            return !empty($row['name']) && !empty($row['size']);
        }));
        if ($totalQuantity < 10) {
            return redirect()->back()->withErrors('You must have at least 10 customization entries.');
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

        return redirect()->route('home')->with('message', 'Customization details submitted successfully!');
    }


    public function confirmJerseyBulkCustom(Request $request, $token)
    {
        $order = Order::where('order_id', $request->order_id)
            ->where('token', $token)
            ->first();

        if (!$order) {
            return redirect()->route('home')->withErrors('Invalid token or order.');
        }

        $rows = old('rows', array_fill(0, 10, ['name' => '', 'jerseyNo' => '', 'topSize' => '', 'shortSize' => '', 'hasPocket' => '', 'remarks' => '']));

        return view('customer.order-confirmation.jersey-bulk-customized', compact('order', 'rows'));
    }

    public function confirmJerseyBulkCustomPost(Request $request)
    {
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
            return redirect()->back()->withErrors('You are not authorized to confirm this order.');
        }

        $totalQuantity = count(array_filter($validatedData['rows'], function ($row) {
            return !empty($row['name']) && !empty($row['topSize']) && !empty($row['shortSize']);
        }));

        if ($totalQuantity < 10) {
            return redirect()->back()->withErrors('You must have at least 10 customization entries.');
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

        return redirect()->route('home')->with('message', 'Jersey customization details submitted successfully!');
    }
}
