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
        <div class="max-w-3xl mx-auto">
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
                                <path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"></path>
                                <path d="M4 6v12c0 1.1.9 2 2 2h14v-4"></path>
                                <path d="M18 12c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="font-gilroy font-bold text-2xl text-gray-900">Order Confirmation</h1>
                            <p class="text-gray-500">Order No. <span class="font-medium text-gray-700">{{$order->order_id}}</span></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
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
                            <p class="font-medium">{{$order->apparelType->name}}</p>
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
                <h2 class="font-gilroy font-bold text-xl mb-6">Specify Size Quantities</h2>
                <p class="text-gray-600 mb-6">Please indicate how many items of each size you would like to order.</p>
                
                <form action="{{ route('confirm-bulk-post') }}" method="POST">
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

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                        @foreach($sizes as $size)
                        <div class="flex flex-col p-4 border border-gray-200 rounded-lg hover:border-cPrimary transition-colors">
                            <label for="size-{{ $size->sizes_ID }}" class="font-medium text-gray-800 mb-2">{{ $size->name }}</label>
                            <div class="relative rounded-md shadow-sm">
                                <input 
                                    type="number" 
                                    id="size-{{ $size->sizes_ID }}" 
                                    name="sizes[{{ $size->sizes_ID }}]" 
                                    class="block w-full rounded-md border-gray-300 focus:border-cPrimary focus:ring focus:ring-cPrimary focus:ring-opacity-20 px-3 py-2"
                                    min="0" 
                                    placeholder="0" 
                                    value="{{ old('sizes.' . $size->sizes_ID, 0) }}"
                                >
                            </div>
                            @error('sizes.' . $size->sizes_ID)
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        @endforeach
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
                            <span class="text-sm text-gray-700">The total quantity must be at least 10 items for bulk orders.</span>
                        </div>
                        <div id="quantity-counter" class="font-medium text-lg">Total: <span id="total-quantity">0</span></div>
                    </div>
                    
                    <!-- Order Price Summary -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                        <h3 class="font-gilroy font-medium text-lg text-gray-900 mb-3">Order Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Quantity:</span>
                                <span id="summary-quantity" class="font-medium">0 items</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Unit Price:</span>
                                <span id="summary-unit-price" class="font-medium">₱{{ number_format($order->final_price / $order->quantity, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Original Downpayment (Paid):</span>
                                <span class="font-medium">₱{{ number_format($order->downpayment_amount, 2) }}</span>
                                <input type="hidden" id="original-downpayment" value="{{ $order->downpayment_amount }}">
                            </div>
                            <div class="flex justify-between items-center border-t border-gray-200 pt-2 mt-2">
                                <span class="text-gray-800 font-medium">New Total Price:</span>
                                <span id="summary-total-price" class="text-cPrimary font-bold text-lg">₱0.00</span>
                            </div>
                            <div class="flex justify-between items-center text-sm pt-1">
                                <span class="text-gray-600">Balance Due:</span>
                                <span id="summary-balance" class="font-bold">₱0.00</span>
                            </div>
                        </div>
                        <input type="hidden" name="new_total_price" id="new-total-price-input" value="0">
                        <input type="hidden" name="new_quantity" id="new-quantity-input" value="0">
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        <a href="{{ route('home') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Home
                        </a>
                        <button type="submit" id="confirm-button" class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-cPrimary hover:bg-cPrimary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            Confirm Order
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    
    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sizeInputs = document.querySelectorAll('input[type="number"]');
            const totalQuantityDisplay = document.getElementById('total-quantity');
            const confirmButton = document.getElementById('confirm-button');
            const quantityCounter = document.getElementById('quantity-counter');
            
            function updateTotalQuantity() {
                let total = 0;
                sizeInputs.forEach(input => {
                    total += parseInt(input.value) || 0;
                });
                
                totalQuantityDisplay.textContent = total;
                
                // Update the order summary
                updateOrderSummary(total);
                
                // Visual feedback based on quantity
                if (total >= 10) {
                    quantityCounter.classList.remove('text-red-500');
                    quantityCounter.classList.add('text-green-600');
                    confirmButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    confirmButton.disabled = false;
                } else {
                    quantityCounter.classList.remove('text-green-600');
                    quantityCounter.classList.add('text-red-500');
                }
            }
            
            function updateOrderSummary(totalQuantity) {
                const unitPrice = parseFloat(document.getElementById('unit-price').value);
                const originalDownpayment = parseFloat(document.getElementById('original-downpayment').value);
                const totalPrice = unitPrice * totalQuantity;
                const balanceDue = totalPrice - originalDownpayment;
                
                document.getElementById('summary-quantity').textContent = totalQuantity + ' item' + (totalQuantity !== 1 ? 's' : '');
                document.getElementById('summary-total-price').textContent = '₱' + totalPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                document.getElementById('summary-balance').textContent = '₱' + Math.max(0, balanceDue).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                
                // Update hidden inputs for form submission
                document.getElementById('new-total-price-input').value = totalPrice.toFixed(2);
                document.getElementById('new-quantity-input').value = totalQuantity;
            }
            
            // Set initial state
            updateTotalQuantity();
            
            // Add event listeners to all number inputs
            sizeInputs.forEach(input => {
                input.addEventListener('input', updateTotalQuantity);
            });
        });
    </script>
</body>
</html>