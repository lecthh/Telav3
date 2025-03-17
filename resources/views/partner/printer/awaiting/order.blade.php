@php
$orderStatusText = "Awaiting Printing";
$nextStageRoute = "partner.printer.awaiting-x-post";
$nextStageText = "Start Printing";
$showCustomizationDetails = true;
@endphp

@extends('partner.printer.layout.order-detail-template')
@section('pageSpecificContent')
<div class="bg-white rounded-lg shadow-sm mb-6">
    <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
        <h3 class="font-gilroy font-bold text-white text-base">Set Estimated Completion Date</h3>
    </div>
    <div class="p-6">
        <form action="{{ route('partner.printer.awaiting-x-post', $order->order_id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="eta" class="block text-sm font-medium text-gray-700 mb-1">Estimated Completion Date</label>
                <input type="date" id="eta" name="eta" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cPrimary focus:border-cPrimary sm:text-sm">
                <p class="mt-1 text-sm text-gray-500">This date will be visible to the customer and will appear on their order tracking.</p>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cPrimary hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Set ETA and Start Printing
                </button>
            </div>
        </form>
    </div>
</div>
@endsection