@php
$orderStatusText = "Ready to Finalize";
$nextStageRoute = "partner.printer.finalize-x-post";
$nextStageText = "Prepare for Printing";
$showCustomizationDetails = true;
$pageSpecificContent = '
<div class="bg-white rounded-lg shadow-sm">
    <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
        <h3 class="font-gilroy font-bold text-white text-base">Design Review</h3>
    </div>
    <div class="p-4">
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Designs Approved by Customer</h3>
                    <div class="mt-2 text-sm text-green-700">
                        <p>The customer has approved the designs. The order is now ready to be prepared for printing.</p>
                    </div>
                    '.($order->customizationDetails && !$order->customizationDetails->isEmpty() ? 
                    '<div class="mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="mr-1.5 h-2 w-2 text-green-600" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Customization Form Completed
                        </span>
                    </div>' : 
                    '<div class="mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <svg class="mr-1.5 h-2 w-2 text-red-600" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Waiting for Customization Form
                        </span>
                    </div>').'
                </div>
            </div>
        </div>
        
        <div class="mb-4">
            <h4 class="font-gilroy font-bold text-base mb-2">Comparison: Original Request vs Final Design</h4>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div>
                    <h5 class="text-sm font-medium text-gray-500 mb-2">Original Request</h5>
                    <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                        '.(!$order->imagesWithStatusOne->isEmpty() ? 
                        '<img src="'.asset('storage/'.$order->imagesWithStatusOne->first()->image).'" alt="Original Request" class="w-full h-full object-contain">' : 
                        '<div class="flex items-center justify-center h-full">
                            <p class="text-gray-400 italic">No image available</p>
                        </div>').'
                    </div>
                </div>
                <div>
                    <h5 class="text-sm font-medium text-gray-500 mb-2">Final Design</h5>
                    <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                        '.(!$order->imagesWithStatusTwo->isEmpty() ? 
                        '<img src="'.asset('storage/'.$order->imagesWithStatusTwo->first()->image).'" alt="Final Design" class="w-full h-full object-contain">' : 
                        '<div class="flex items-center justify-center h-full">
                            <p class="text-gray-400 italic">No image available</p>
                        </div>').'
                    </div>
                </div>
            </div>
        </div>
        
        '.(!$order->customizationDetails || $order->customizationDetails->isEmpty() ? 
        '<div class="p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Waiting for Customer Input</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>The customer needs to complete the customization form before the order can proceed to printing. The system has sent them a notification.</p>
                    </div>
                </div>
            </div>
        </div>' : '').'
    </div>
</div>
';
@endphp

@extends('partner.printer.layout.order-detail-template')