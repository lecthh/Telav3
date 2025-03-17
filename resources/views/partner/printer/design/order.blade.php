@php
$orderStatusText = "In Design";
$pageSpecificContent = '
<div class="bg-white rounded-lg shadow-sm">
    <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
        <h3 class="font-gilroy font-bold text-white text-base">Design Progress</h3>
    </div>
    <div class="p-4">
        <div class="flex items-center p-4 mb-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
            <div class="flex-shrink-0 mr-3">
                <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="font-medium text-blue-800">Designer is currently working on this order</p>
                <p class="text-sm text-blue-700">The designer will upload completed designs when finished. You\'ll be notified once designs are ready for review.</p>
            </div>
        </div>
        
        <div class="mb-4">
            <h4 class="font-gilroy font-medium text-gray-700 mb-2">Designer Details</h4>
            <div class="bg-white border border-gray-200 rounded-lg p-4 flex items-center">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-14 h-14 rounded-full bg-cAccent flex items-center justify-center text-white font-bold text-xl">
                        '.substr($order->designer->user->name, 0, 1).'
                    </div>
                </div>
                <div>
                    <h5 class="font-gilroy font-bold text-lg">'.$order->designer->user->name.'</h5>
                    <p class="text-gray-600 text-sm">'.$order->designer->is_freelancer ? 'Freelance Designer' : 'In-house Designer'.'</p>
                    <div class="flex items-center mt-1">
                        <div class="flex">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <span class="text-xs text-gray-500 ml-1">('.$order->designer->average_rating ?? '4.0'.'/5)</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-gilroy font-medium text-gray-700 mb-2">Estimated Timeline</h4>
            <div class="space-y-3">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <p class="font-medium">Design Started</p>
                        <p class="text-xs text-gray-500">'.$order->updated_at->format('M d, Y g:i A').'</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                        <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                    </div>
                    <div>
                        <p class="font-medium">Design In Progress</p>
                        <p class="text-xs text-gray-500">Estimated: 1-2 days</p>
                    </div>
                </div>
                <div class="flex items-center opacity-50">
                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                    </div>
                    <div>
                        <p class="font-medium">Design Approval</p>
                        <p class="text-xs text-gray-500">Pending</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
';
@endphp

@extends('partner.printer.layout.order-detail-template')