<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('layout.nav')
    
    <main class="flex-grow py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section with Order Info -->
            <div class="mb-8">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <a href="{{ route('home') }}" class="hover:text-cPrimary">Home</a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span>Order Confirmation</span>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-cPrimary/10 flex items-center justify-center text-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="font-gilroy font-bold text-2xl text-gray-900">Jersey Customization</h1>
                            <p class="text-gray-500">Order No. <span class="font-medium text-gray-700">{{ $order->order_id }}</span></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Customer</p>
                            <p class="font-medium">{{$order->user->name}}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Order Date</p>
                            <p class="font-medium">{{$order->created_at->format('F j, Y')}}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Apparel Type</p>
                            <p class="font-medium">Jersey Set</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Production Method</p>
                            <p class="font-medium">{{$order->productionType->name}}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Unit Price</p>
                            <p class="font-medium">₱{{ number_format($order->final_price / $order->quantity, 2) }}</p>
                            <input type="hidden" id="unit-price" value="{{ $order->final_price / $order->quantity }}">
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Original Total Price</p>
                            <p class="font-medium">₱{{ number_format($order->final_price, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="mb-6">
                    <h2 class="font-gilroy font-bold text-xl mb-2">Jersey Customization Details</h2>
                    <p class="text-gray-600">Please specify the details for each jersey to be printed. You must provide at least 10 customization entries.</p>
                </div>
                
                <form action="{{ route('confirm-jerseybulk-custom-post') }}" method="POST" id="customizationForm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                    <input type="hidden" name="token" value="{{ $order->token }}">

                    @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="overflow-hidden border border-gray-200 rounded-lg mb-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-cPrimary">
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-12">No.</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Player Name</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-24">Jersey #</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-28">Top Size</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-28">Short Size</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-20">Pocket</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Remarks</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-20">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="rowsTable" class="bg-white divide-y divide-gray-200">
                                    @foreach($rows as $index => $row)
                                    <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="px-2 py-4 text-sm font-medium text-gray-900 align-top">{{ $index + 1 }}</td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <input type="text" name="rows[{{ $index }}][name]" 
                                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                                                placeholder="Player name" 
                                                value="{{ old('rows.'.$index.'.name', $row['name']) }}">
                                            @error('rows.'.$index.'.name')
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <input type="text" name="rows[{{ $index }}][jerseyNo]" 
                                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                                                placeholder="00" 
                                                value="{{ old('rows.'.$index.'.jerseyNo', $row['jerseyNo']) }}">
                                            @error('rows.'.$index.'.jerseyNo')
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <select name="rows[{{ $index }}][topSize]" 
                                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none">
                                                <option value="2" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'XS' ? 'selected' : '' }}>XS</option>
                                                <option value="3" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'S' ? 'selected' : '' }}>S</option>
                                                <option value="4" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'M' ? 'selected' : '' }}>M</option>
                                                <option value="5" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'L' ? 'selected' : '' }}>L</option>
                                                <option value="6" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'XL' ? 'selected' : '' }}>XL</option>
                                                <option value="7" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'XXL' ? 'selected' : '' }}>XXL</option>
                                            </select>
                                            @error('rows.'.$index.'.topSize')
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <select name="rows[{{ $index }}][shortSize]" 
                                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none">
                                                <option value="2" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'XS' ? 'selected' : '' }}>XS</option>
                                                <option value="3" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'S' ? 'selected' : '' }}>S</option>
                                                <option value="4" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'M' ? 'selected' : '' }}>M</option>
                                                <option value="5" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'L' ? 'selected' : '' }}>L</option>
                                                <option value="6" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'XL' ? 'selected' : '' }}>XL</option>
                                                <option value="7" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'XXL' ? 'selected' : '' }}>XXL</option>
                                            </select>
                                            @error('rows.'.$index.'.shortSize')
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500 text-center">
                                            <div class="flex justify-center">
                                                <input type="hidden" name="rows[{{ $index }}][hasPocket]" value="0">
                                                <input type="checkbox" name="rows[{{ $index }}][hasPocket]" value="1" 
                                                    {{ old('rows.'.$index.'.hasPocket', $row['hasPocket'] ?? false) ? 'checked' : '' }} 
                                                    class="w-5 h-5 text-cPrimary border-gray-300 rounded focus:ring-cPrimary">
                                                @error('rows.'.$index.'.hasPocket')
                                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <input type="text" name="rows[{{ $index }}][remarks]" 
                                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                                                placeholder="Optional notes" 
                                                value="{{ old('rows.'.$index.'.remarks', $row['remarks']) }}">
                                            @error('rows.'.$index.'.remarks')
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <button type="button" onclick="removeRow(this)" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-700">You must have at least 10 customization entries.</span>
                        </div>
                        <div id="entry-counter" class="font-medium text-lg">Total Entries: <span id="total-entries">{{ count($rows) }}</span></div>
                    </div>
                    
                    <!-- Order Price Summary -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                        <h3 class="font-gilroy font-medium text-lg text-gray-900 mb-3">Order Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Quantity:</span>
                                <span id="summary-quantity" class="font-medium">{{ count($rows) }} items</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Unit Price:</span>
                                <span class="font-medium">₱{{ number_format($order->final_price / $order->quantity, 2) }}</span>
                                <input type="hidden" id="unit-price" value="{{ $order->final_price / $order->quantity }}">
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Original Downpayment (Paid):</span>
                                <span class="font-medium">₱{{ number_format($order->downpayment_amount, 2) }}</span>
                                <input type="hidden" id="original-downpayment" value="{{ $order->downpayment_amount }}">
                            </div>
                            <div class="flex justify-between items-center border-t border-gray-200 pt-2 mt-2">
                                <span class="text-gray-800 font-medium">New Total Price:</span>
                                <span class="text-cPrimary font-bold text-lg">₱{{ number_format($order->final_price, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm pt-1">
                                <span class="text-gray-600">Additional Payment Required:</span>
                                <span id="additional-payment" class="font-bold text-orange-600">₱0.00</span>
                            </div>
                            <div class="flex justify-between items-center text-sm pt-1">
                                <span class="text-gray-600">Balance Due:</span>
                                <span class="font-bold">₱{{ number_format($order->final_price - $order->downpayment_amount, 2) }}</span>
                            </div>
                        </div>
                        
                        <!-- Payment Notification -->
                        <div id="payment-notification" class="mt-4 bg-yellow-50 border border-yellow-200 rounded-md p-4 hidden">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Additional Payment Required</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Your order quantity has changed. Please pay the additional downpayment of <span id="notification-amount" class="font-bold">₱0.00</span> to proceed with your updated order.</p>
                                    </div>
                                    <div class="mt-4">
                                        <!-- Payment button has been removed -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="additional_payment_required" id="additional-payment-input" value="0">
                    </div>

                    <div class="mb-6">
                        <button type="button" onclick="addRow()" class="inline-flex items-center px-4 py-2 border border-cPrimary rounded-md shadow-sm text-sm font-medium text-cPrimary bg-white hover:bg-cPrimary/5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add Player
                        </button>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        <a href="{{ route('home') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Home
                        </a>
                        <div class="inline-flex gap-3">
                            <button type="button" id="payment-button" class="hidden inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                Pay Additional Amount
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button type="submit" id="confirm-button" class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-cPrimary hover:bg-cPrimary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary disabled:opacity-50 disabled:cursor-not-allowed">
                                Confirm Order
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    
    @include('layout.footer')

    <script>
        let rowIndex = @json(count($rows));

        function addRow() {
            const rowsTable = document.getElementById('rowsTable');
            const rowCount = rowsTable.rows.length;
            const isOdd = rowCount % 2;
            
            const newRow = `
                <tr class="${isOdd ? 'bg-gray-50' : 'bg-white'}">
                    <td class="px-2 py-4 text-sm font-medium text-gray-900 align-top">${rowCount + 1}</td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <input type="text" name="rows[${rowCount}][name]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                            placeholder="Player name">
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <input type="text" name="rows[${rowCount}][jerseyNo]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                            placeholder="00">
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <select name="rows[${rowCount}][topSize]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none">
                            <option value="2">XS</option>
                            <option value="3">S</option>
                            <option value="4">M</option>
                            <option value="5">L</option>
                            <option value="6">XL</option>
                            <option value="7">XXL</option>
                        </select>
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <select name="rows[${rowCount}][shortSize]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none">
                            <option value="2">XS</option>
                            <option value="3">S</option>
                            <option value="4">M</option>
                            <option value="5">L</option>
                            <option value="6">XL</option>
                            <option value="7">XXL</option>
                        </select>
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500 text-center">
                        <div class="flex justify-center">
                            <input type="hidden" name="rows[${rowCount}][hasPocket]" value="0">
                            <input type="checkbox" name="rows[${rowCount}][hasPocket]" value="1" 
                                class="w-5 h-5 text-cPrimary border-gray-300 rounded focus:ring-cPrimary">
                        </div>
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <input type="text" name="rows[${rowCount}][remarks]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                            placeholder="Optional notes">
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <button type="button" onclick="removeRow(this)" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete
                        </button>
                    </td>
                </tr>`;
                
            rowsTable.insertAdjacentHTML('beforeend', newRow);
            rowIndex++;
            updateEntryCount();
        }

        function removeRow(button) {
            const row = button.closest('tr');
            row.remove();
            updateRowNumbers();
            updateEntryCount();
        }

        function updateRowNumbers() {
            const rows = document.querySelectorAll('#rowsTable tr');
            rows.forEach((row, index) => {
                row.firstElementChild.textContent = index + 1;
                // Update classes for zebra striping
                if (index % 2 === 0) {
                    row.classList.remove('bg-gray-50');
                    row.classList.add('bg-white');
                } else {
                    row.classList.remove('bg-white');
                    row.classList.add('bg-gray-50');
                }
            });
        }
        
        function updateEntryCount() {
            const totalEntriesElement = document.getElementById('total-entries');
            const entryCounterElement = document.getElementById('entry-counter');
            const rows = document.querySelectorAll('#rowsTable tr');
            const count = rows.length;
            
            totalEntriesElement.textContent = count;
            
            if (count >= 10) {
                entryCounterElement.classList.remove('text-red-500');
                entryCounterElement.classList.add('text-green-600');
            } else {
                entryCounterElement.classList.remove('text-green-600');
                entryCounterElement.classList.add('text-red-500');
            }
            
            // Update order summary
            updateOrderSummary(count);
        }
        
        function updateOrderSummary(totalQuantity) {
            const unitPrice = parseFloat(document.getElementById('unit-price').value);
            const originalDownpayment = parseFloat(document.getElementById('original-downpayment').value);
            const originalQuantity = {{ $order->quantity }};
            const confirmButton = document.getElementById('confirm-button');
            const paymentButton = document.getElementById('payment-button');
            
            // Calculate prices
            const originalTotalPrice = unitPrice * originalQuantity;
            const newTotalPrice = unitPrice * totalQuantity;
            const priceDifference = newTotalPrice - originalTotalPrice;
            
            // Calculate required payments
            const additionalPaymentRequired = priceDifference > 0 ? priceDifference / 2 : 0; // 50% downpayment on additional items
            const newBalanceDue = newTotalPrice - originalDownpayment - additionalPaymentRequired;
            
            // Update display elements
            document.getElementById('summary-quantity').textContent = totalQuantity + ' item' + (totalQuantity !== 1 ? 's' : '');
            
            const totalPriceElement = document.querySelector('.text-cPrimary.font-bold.text-lg');
            if (totalPriceElement) {
                totalPriceElement.textContent = '₱' + newTotalPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            }
            
            const additionalPaymentElement = document.getElementById('additional-payment');
            if (additionalPaymentElement) {
                additionalPaymentElement.textContent = '₱' + additionalPaymentRequired.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            }
            
            const balanceDueElement = document.querySelector('.flex.justify-between.items-center.text-sm.pt-1:last-child .font-bold');
            if (balanceDueElement) {
                balanceDueElement.textContent = '₱' + Math.max(0, newBalanceDue).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            }
            
            // Update notification amount
            const notificationAmountElement = document.getElementById('notification-amount');
            if (notificationAmountElement) {
                notificationAmountElement.textContent = '₱' + additionalPaymentRequired.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            }
            
            // Show/hide notification based on whether additional payment is required
            const paymentNotification = document.getElementById('payment-notification');
            if (paymentNotification) {
                if (additionalPaymentRequired > 0) {
                    paymentNotification.classList.remove('hidden');
                } else {
                    paymentNotification.classList.add('hidden');
                }
            }
            
            // Update hidden field for form submission
            document.getElementById('additional-payment-input').value = additionalPaymentRequired.toFixed(2);
            
            // Enable/disable confirm button based on additional payment required
            if (additionalPaymentRequired > 0) {
                // Disable confirm button and show payment button when additional payment is required
                confirmButton.disabled = true;
                paymentButton.classList.remove('hidden');
            } else {
                // Enable confirm button and hide payment button when no additional payment is required
                confirmButton.disabled = false;
                paymentButton.classList.add('hidden');
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the form
            updateEntryCount();
            
            // Add event listener for form submission
            document.getElementById('customizationForm').addEventListener('submit', function(e) {
                const rows = document.querySelectorAll('#rowsTable tr');
                if (rows.length < 10) {
                    e.preventDefault();
                    alert('You must have at least 10 customization entries to proceed.');
                    return false;
                }
                return true;
            });
            
            // Add event listener for the payment methods button
            const viewPaymentMethodsButton = document.getElementById('view-payment-methods');
            if (viewPaymentMethodsButton) {
                viewPaymentMethodsButton.addEventListener('click', function() {
                    // Redirect to payment methods page
                    window.location.href = "{{ route('customer.payment.methods', ['order_id' => $order->order_id ?? '0', 'additional_payment' => '__PAYMENT_AMOUNT__']) }}".replace('__PAYMENT_AMOUNT__', document.getElementById('additional-payment-input').value);
                });
            }
            
            // Add event listener for the payment button
            const paymentButton = document.getElementById('payment-button');
            if (paymentButton) {
                paymentButton.addEventListener('click', function() {
                    // Redirect to payment methods page
                    window.location.href = "{{ route('customer.payment.methods', ['order_id' => $order->order_id ?? '0', 'additional_payment' => '__PAYMENT_AMOUNT__']) }}".replace('__PAYMENT_AMOUNT__', document.getElementById('additional-payment-input').value);
                });
            }
        });
    </script>
</body>
</html>