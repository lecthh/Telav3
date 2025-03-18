@php
$orderStatusText = "Completed";
$showCustomizationDetails = true;
$pageSpecificContent = '
<div class="bg-white rounded-lg shadow-sm">
    <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
        <h3 class="font-gilroy font-bold text-white text-base">Order Summary</h3>
    </div>
    <div class="p-4">
        <div class="mb-4 p-4 bg-green-50 rounded-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                    <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="font-bold text-green-800">Order Successfully Completed</h4>
                    <p class="text-sm text-green-700">This order has been delivered to the customer and marked as complete.</p>
                </div>
            </div>
        </div>
        
        <div class="divide-y divide-gray-200">
            <div class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Order Date:</span>
                <span class="font-bold text-gray-900">'.$order->created_at->format('F j, Y').'</span>
            </div>
            <div class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Completion Date:</span>
                <span class="font-bold text-gray-900">'.$order->updated_at->format('F j, Y').'</span>
            </div>
            <div class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Final Payment:</span>
                <span class="font-bold text-green-600">'.number_format($order->final_price, 2).' PHP</span>
            </div>
        </div>
    </div>
</div>
';
@endphp

@extends('partner.printer.layout.order-detail-template')