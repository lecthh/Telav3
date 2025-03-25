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
        <div class="max-w-4xl mx-auto">
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
                            <p class="font-medium">{{$order->apparelType->name}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="font-gilroy font-bold text-xl mb-2">Personalized Customization Details</h2>
                <p class="text-gray-600 mb-6">Please specify the details for each apparel to be printed. For single orders, you can provide between 1 and 9 customization entries.</p>
                
                <form action="{{ route('confirm-single-custom-post') }}" method="POST" id="customizationForm">
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

                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                            <thead>
                                <tr class="bg-cPrimary">
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-12">No.</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Size</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Remarks</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-24">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="rowsTable" class="bg-white divide-y divide-gray-200">
                                @foreach ($rows as $index => $row)
                                <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-4 py-4 text-sm font-medium text-gray-900 align-top">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-500">
                                        <input type="text" name="rows[{{ $index }}][name]" 
                                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                                            placeholder="Customer name" 
                                            value="{{ old('rows.'.$index.'.name') }}">
                                        @error("rows.$index.name")
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-500">
                                        <select name="rows[{{ $index }}][size]" 
                                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none">
                                            <option value="">Select Size</option>
                                            @foreach($sizes as $size)
                                            <option value="{{ $size->sizes_ID }}" {{ old('rows.'.$index.'.size') == $size->sizes_ID ? 'selected' : '' }}>
                                                {{ $size->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error("rows.$index.size")
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-500">
                                        <input type="text" name="rows[{{ $index }}][remarks]" 
                                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                                            placeholder="Optional notes" 
                                            value="{{ old('rows.'.$index.'.remarks') }}">
                                        @error("rows.$index.remarks")
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-500">
                                        <button type="button" onclick="removeRow(this)" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                            <span class="text-sm text-gray-700">For single orders, you can provide between 1 and 9 customization entries.</span>
                        </div>
                        <div id="entry-counter" class="font-medium text-lg">Total Entries: <span id="total-entries">{{ count($rows) }}</span></div>
                    </div>
                    
                    <!-- Hidden inputs for additional payment -->
                    <input type="hidden" name="new_total_price" id="new-total-price-input" value="0">
                    <input type="hidden" name="new_quantity" id="new-quantity-input" value="0">
                    <input type="hidden" name="additional_payment" id="additional-payment-input" value="0">
                    
                    <!-- Alert message for additional payment -->
                    <div id="additional-payment-alert" class="hidden mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Additional payment required</h3>
                                <p class="mt-1 text-sm text-yellow-700">You have added more items than the original order. You must pay the additional downpayment before confirming.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional payment summary section -->
                    <div id="additional-payment-section" class="hidden mb-6 bg-white border border-gray-200 rounded-lg p-4">
                        <h3 class="font-medium text-lg mb-3">Order Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Original Quantity:</span>
                                <span class="font-medium">{{ $order->quantity }} item(s)</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">New Quantity:</span>
                                <span id="summary-quantity" class="font-medium">0 items</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Price:</span>
                                <span id="summary-total-price" class="font-medium">₱0.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Original Downpayment:</span>
                                <span class="font-medium">₱{{ number_format($order->downpayment_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Additional Payment:</span>
                                <span id="additional-payment" class="font-medium text-cPrimary">₱0.00</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Balance Due:</span>
                                    <span id="summary-balance" class="font-medium">₱0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <button type="button" onclick="addRow()" class="inline-flex items-center px-4 py-2 border border-cPrimary rounded-md shadow-sm text-sm font-medium text-cPrimary bg-white hover:bg-cPrimary/5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add Entry
                        </button>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        <a href="{{ route('home') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Home
                        </a>
                        
                        <!-- Additional payment button (hidden by default) -->
                        <a id="pay-additional-btn" href="#" class="hidden inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bbg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            Pay Additional Amount
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        
                        <!-- Regular confirm button -->
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
        function addRow() {
            const rowsTable = document.getElementById('rowsTable');
            const rowCount = rowsTable.rows.length;
            const sizesOptions = `@foreach($sizes as $size)<option value="{{ $size->sizes_ID }}">{{ $size->name }}</option>@endforeach`;
            const isOdd = rowCount % 2;
            
            const newRow = `
                <tr class="${isOdd ? 'bg-gray-50' : 'bg-white'}">
                    <td class="px-4 py-4 text-sm font-medium text-gray-900 align-top">${rowCount + 1}</td>
                    <td class="px-4 py-4 text-sm text-gray-500">
                        <input type="text" name="rows[${rowCount}][name]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                            placeholder="Customer name">
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-500">
                        <select name="rows[${rowCount}][size]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none">
                            <option value="">Select Size</option>
                            ${sizesOptions}
                        </select>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-500">
                        <input type="text" name="rows[${rowCount}][remarks]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                            placeholder="Optional notes">
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-500">
                        <button type="button" onclick="removeRow(this)" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete
                        </button>
                    </td>
                </tr>`;
                
            rowsTable.insertAdjacentHTML('beforeend', newRow);
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
            
            // Get references to UI elements
            const additionalPaymentSection = document.getElementById('additional-payment-section');
            const additionalPaymentAlert = document.getElementById('additional-payment-alert');
            const payAdditionalBtn = document.getElementById('pay-additional-btn');
            const confirmButton = document.getElementById('confirm-button');
            
            // Get original quantity value from the server-side data
            const originalQuantity = {{ $order->quantity }};
            
            // Update UI based on the count
            if (count >= 1 && count <= 9) {
                entryCounterElement.classList.remove('text-red-500');
                entryCounterElement.classList.add('text-green-600');
                
                // Check if quantity has increased compared to original order
                if (count > originalQuantity) {
                    // Show additional payment UI
                    additionalPaymentSection.classList.remove('hidden');
                    additionalPaymentAlert.classList.remove('hidden');
                    payAdditionalBtn.classList.remove('hidden');
                    
                    // Disable regular confirm button
                    confirmButton.disabled = true;
                    confirmButton.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                    confirmButton.classList.remove('bg-cPrimary', 'hover:bg-cPrimary/90');
                    
                    // Calculate additional payment info
                    updateOrderSummary(count);
                } else {
                    // Hide additional payment UI
                    additionalPaymentSection.classList.add('hidden');
                    additionalPaymentAlert.classList.add('hidden');
                    payAdditionalBtn.classList.add('hidden');
                    
                    // Enable regular confirm button
                    confirmButton.disabled = false;
                    confirmButton.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                    confirmButton.classList.add('bg-cPrimary', 'hover:bg-cPrimary/90');
                }
            } else {
                entryCounterElement.classList.remove('text-green-600');
                entryCounterElement.classList.add('text-red-500');
                
                // Disable confirm button if count is invalid
                confirmButton.disabled = true;
                confirmButton.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                confirmButton.classList.remove('bg-cPrimary', 'hover:bg-cPrimary/90');
                
                // Hide additional payment UI
                additionalPaymentSection.classList.add('hidden');
                additionalPaymentAlert.classList.add('hidden');
                payAdditionalBtn.classList.add('hidden');
            }
        }
        
        function updateOrderSummary(totalQuantity) {
            // Get original values from server-side data
            const originalQuantity = {{ $order->quantity }};
            const unitPrice = {{ $order->final_price / $order->quantity }};
            const originalDownpayment = {{ $order->downpayment_amount }};
            
            // Calculate new values
            const totalPrice = unitPrice * totalQuantity;
            const additionalQuantity = Math.max(0, totalQuantity - originalQuantity);
            const additionalPaymentAmount = (additionalQuantity * unitPrice) / 2; // 50% down payment for additional items
            const balanceDue = totalPrice - originalDownpayment - additionalPaymentAmount;
            
            // Update display
            document.getElementById('summary-quantity').textContent = totalQuantity + ' item' + (totalQuantity !== 1 ? 's' : '');
            document.getElementById('summary-total-price').textContent = '₱' + totalPrice.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById('summary-balance').textContent = '₱' + Math.max(0, balanceDue).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            if (additionalPaymentAmount > 0) {
                document.getElementById('additional-payment').textContent = '₱' + additionalPaymentAmount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
            
            // Update hidden inputs for form submission
            document.getElementById('new-total-price-input').value = totalPrice.toFixed(2);
            document.getElementById('new-quantity-input').value = totalQuantity;
            document.getElementById('additional-payment-input').value = additionalPaymentAmount.toFixed(2);
            
            // Update Pay Additional button link with order ID, amount, and size data
            const payAdditionalBtn = document.getElementById('pay-additional-btn');
            if (payAdditionalBtn) {
                // Collect form data for customizations
                const formData = collectFormData();
                
                // Encode the form data as JSON and add to the URL
                const formDataParam = encodeURIComponent(JSON.stringify(formData));
                payAdditionalBtn.href = "{{ route('order.additional-payment', ['order_id' => $order->order_id]) }}?amount=" +
                    additionalPaymentAmount.toFixed(2) +
                    "&quantity=" + additionalQuantity +
                    "&size_data=" + formDataParam;
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            updateEntryCount();
            
            // Add event listener for the pay additional button
            const payAdditionalBtn = document.getElementById('pay-additional-btn');
            if (payAdditionalBtn) {
                payAdditionalBtn.addEventListener('click', function(e) {
                    // Form validation before proceeding to payment
                    const formData = collectFormData();
                    if (formData.length === 0) {
                        e.preventDefault();
                        alert('Please fill in at least one customization entry with name and size before proceeding to payment.');
                        return;
                    }
                });
            }
        });

        function collectFormData() {
            const rows = document.querySelectorAll('#rowsTable tr');
            const formData = [];

            rows.forEach((row, index) => {
                const nameInput = row.querySelector('input[name^="rows["][name$="][name]"]');
                const sizeSelect = row.querySelector('select[name^="rows["][name$="][size]"]');
                const remarksInput = row.querySelector('input[name^="rows["][name$="][remarks]"]');

                // For jersey forms, get additional fields
                const jerseyNoInput = row.querySelector('input[name^="rows["][name$="][jerseyNo]"]');
                const topSizeSelect = row.querySelector('select[name^="rows["][name$="][topSize]"]');
                const shortSizeSelect = row.querySelector('select[name^="rows["][name$="][shortSize]"]');
                const hasPocketCheckbox = row.querySelector('input[name^="rows["][name$="][hasPocket]"][type="checkbox"]');

                // Only include row if name and size are filled
                if (nameInput && nameInput.value && sizeSelect && sizeSelect.value) {
                    const rowData = {
                        name: nameInput.value,
                        size: sizeSelect.value,
                        remarks: remarksInput ? remarksInput.value : ''
                    };

                    // Add jersey specific fields if they exist
                    if (jerseyNoInput) rowData.jerseyNo = jerseyNoInput.value;
                    if (topSizeSelect) rowData.topSize = topSizeSelect.value;
                    if (shortSizeSelect) rowData.shortSize = shortSizeSelect.value;
                    if (hasPocketCheckbox) rowData.hasPocket = hasPocketCheckbox.checked;

                    formData.push(rowData);
                }
            });

            return formData;
        }

        document.getElementById('pay-additional-btn').addEventListener('click', function(e) {
            e.preventDefault();

            // Get the current href
            const baseHref = this.getAttribute('href').split('?')[0];
            const urlParams = new URLSearchParams(this.getAttribute('href').split('?')[1]);

            // Collect form data
            const formData = collectFormData();

            // Only proceed if we have valid data
            if (formData.length === 0) {
                alert('Please fill in at least one customization entry before proceeding to payment.');
                return;
            }

            // Add the form data to the URL
            urlParams.set('size_data', JSON.stringify(formData));

            // Set the new href and navigate
            const newHref = baseHref + '?' + urlParams.toString();
            window.location.href = newHref;
        });
    </script>
</body>
</html>