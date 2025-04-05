@php
$orderStatusText = "Ready for Collection";
$nextStageRoute = "partner.printer.ready-x-post";
$nextStageText = "Mark as Completed";
$showCustomizationDetails = true;
@endphp

@section('pageSpecificContent')
<div class="bg-white rounded-lg shadow-sm">
    <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
        <h3 class="font-gilroy font-bold text-white text-base">Payment Information</h3>
    </div>
    <div class="p-4">
        <div class="divide-y divide-gray-200">
            <div class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Original Price:</span>
                <span class="font-bold text-gray-900">{{ number_format($order->final_price, 2) }} PHP</span>
            </div>
            <div class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Down Payment Received:</span>
                <span class="font-bold text-green-600">{{ number_format($order->downpayment_amount, 2) }} PHP</span>
            </div>
            <div class="py-3 flex justify-between">
                <span class="font-medium text-gray-700">Remaining Balance:</span>
                <span class="font-bold text-red-600">{{ number_format($order->final_price - $order->downpayment_amount, 2) }} PHP</span>
            </div>
        </div>
        
        <div class="mt-4 p-4 bg-green-50 border-l-4 border-green-400 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">
                        Order is ready for collection. Remind the customer to pay the remaining balance upon pickup.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('partner.printer.layout.order-detail-template')

@section('additional-actions')
    @if($order->final_price > $order->downpayment_amount)
        <div class="mt-6">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
                    <h3 class="font-gilroy font-bold text-white text-base">Payment Reminder</h3>
                </div>
                <div class="p-4">
                    <form action="{{ route('partner.printer.send-payment-reminder', ['order_id' => $order->order_id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cPrimary hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            Send Payment Reminder to Customer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection