<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Customization extends Controller
{
    public function customization($apparel, $productionType, $company)
    {
        $currentStep = 4;
        return view('customer.place-order.customization', compact('apparel', 'productionType', 'company', 'currentStep'));
    }

    public function storeCustomization(Request $request, $apparel, $productionType, $company)
    {
        $request->validate([
            'description' => 'nullable|string|max:500',
            'media.*' => 'nullable|mimes:jpeg,png|max:102400',
            'order_type' => 'required|in:bulk,single',
            'custom_type' => 'required|in:standard,personalized',
        ]);

        if ($request->hasFile('media')) {
            $mediaPaths = [];
            foreach ($request->file('media') as $file) {
                $path = $file->store('uploads/designs', 'public');
                $mediaPaths[] = $path;
            }
        }

        $customizationData = [
            'description' => $request->input('description'),
            'media' => $mediaPaths ?? [],
            'order_type' => $request->input('order_type'),
            'custom_type' => $request->input('custom_type'),
        ];

        session()->put('customization', $customizationData);

        return redirect()->route('customer.place-order.review', ['apparel' => $apparel, 'productionType' => $productionType, 'company' => $company]);
    }
}
