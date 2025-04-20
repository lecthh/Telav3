<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex flex-col bg-gray-50">
    <x-blocked-banner-wrapper />
    @include('layout.nav')

    <main class="flex-grow">
        <div class="container mx-auto px-4 py-8 md:py-12 animate-fade-in">
            <div class="mb-8">
                <h1 class="font-gilroy font-bold text-4xl md:text-5xl text-gray-900 mb-6">Profile Page</h1>

                <div class="mb-6 border-b border-gray-200">
                    <nav class="flex -mb-px space-x-8">
                        <a href="{{ route('customer.profile.basics') }}"
                            class="py-4 px-1 border-b-2 border-transparent font-inter text-xl font-bold text-gray-600 hover:text-cPrimary hover:border-gray-300 transition duration-150">
                            Basics
                        </a>
                        <a href="{{ route('customer.profile.orders') }}"
                            class="py-4 px-1 border-b-2 border-cPrimary font-inter text-xl font-bold text-cPrimary transition duration-150"
                            aria-current="page">
                            Orders
                        </a>
                        <a href="{{ route('customer.profile.reviews') }}"
                            class="py-4 px-1 border-b-2 border-transparent font-inter text-xl font-bold text-gray-600 hover:text-cPrimary hover:border-gray-300 transition duration-150">
                            Reviews
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Two-panel layout -->
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left panel: Orders List -->
                <div class="w-full lg:w-1/2 xl:w-2/5 bg-white rounded-lg shadow-sm">
                    <div class="p-6">
                        <h2 class="font-gilroy font-bold text-xl mb-4">Your Orders</h2>

                        <div class="mb-4">
                            <div class="relative">
                                <input type="text" id="order-search" placeholder="Search orders..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cPrimary focus:border-cPrimary">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 max-h-[65vh] overflow-y-auto pr-2 custom-scrollbar">
                            @if(count($orders) > 0)
                            @foreach($orders as $order)
                            <button class="order-button w-full text-left p-4 rounded-lg border border-gray-200 hover:border-cPrimary hover:bg-purple-50 transition duration-150 focus:outline-none focus:ring-2 focus:ring-cPrimary focus:ring-offset-2 group"
                                data-order-id="{{ $order->order_id }}"
                                data-order-status="{{ $order->status->name }}"
                                data-order-status-id="{{ $order->status_id }}"
                                data-order-created-at="{{ $order->created_at }}"
                                data-order-notifications='@json($order->notifications)'
                                data-order-quantity="{{ $order->quantity }}"
                                data-order-production-type="{{ $order->productionType ? $order->productionType->name : 'N/A' }}"
                                data-order-apparel-type="{{ $order->apparelType ? $order->apparelType->name : 'N/A' }}"
                                data-order-company="{{ $order->productionCompany ? $order->productionCompany->company_name : 'N/A' }}"
                                data-order-is-customized="{{ $order->is_customized ? 'Yes' : 'No' }}"
                                data-order-is-bulk="{{ $order->is_bulk_order ? 'Yes' : 'No' }}"
                                data-order-price="{{ $order->final_price }}"
                                data-order-downpayment="{{ $order->downpayment_amount }}"
                                data-order-eta="{{ $order->eta }}"
                                data-order-cancellation-reason="{{ $order->cancellation_reason }}"
                                data-order-cancellation-note="{{ $order->cancellation_note }}"
                                data-order-designer="{{ $order->designer ? $order->designer->user->name : 'Not yet assigned' }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-inter font-bold text-gray-900 group-hover:text-cPrimary transition duration-150">
                                            Order #{{ substr($order->order_id, -6) }}
                                        </h3>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $order->status->name == 'Completed' ? 'bg-green-100 text-green-800' : 
                                                    ($order->status->name == 'Cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                                {{ $order->status->name }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                {{ $order->apparelType ? $order->apparelType->name : '' }}
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $order->created_at->format('M j, Y') }}</span>
                                </div>
                            </button>
                            @endforeach
                            @else
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No orders found</h3>
                                <p class="mt-1 text-sm text-gray-500">You haven't placed any orders yet.</p>
                                <div class="mt-6">
                                    <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cPrimary hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                                        Start Shopping
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right panel - Only ONE of these will be visible at a time -->
                <div class="w-full lg:w-1/2 xl:w-3/5">
                    <!-- Order Details View -->
                    <div id="order-details" class="bg-white rounded-lg shadow-sm animate-fade-in hidden">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="font-gilroy font-bold text-2xl">Order #<span id="order-id-display" class="font-mono"></span></h2>
                                <button id="close-details" class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-6">
                                <div id="order-status-details" class="p-4 bg-gray-50 rounded-lg"></div>

                                <!-- Added order specifications -->
                                <div class="border-t border-gray-200 pt-4">
                                    <h3 class="font-inter font-bold text-lg mb-4">Order Specifications</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <p class="text-gray-500 text-sm">Apparel Type</p>
                                            <p id="order-apparel-type" class="font-medium"></p>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <p class="text-gray-500 text-sm">Production Method</p>
                                            <p id="order-production-type" class="font-medium"></p>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <div class="flex gap-2 items-center">
                                                <p class="text-gray-500 text-sm">Production Company</p>
                                                <span>
                                                    @livewire('report-button', [
                                                    'reporterClass' => auth()->user()->getMorphClassName(),
                                                    'reporterId' => auth()->user()->user_id,
                                                    'reportedClass' => $order->productionCompany->getMorphClassName(),
                                                    'reportedId' => $order->productionCompany->id,
                                                    'orderId' => $order->order_id,
                                                    'entityName' => 'Production Company'
                                                    ])
                                                </span>
                                            </div>
                                            <p id="order-company" class="font-medium"></p>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <p class="text-gray-500 text-sm">Quantity</p>
                                            <p id="order-quantity" class="font-medium"></p>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <p class="text-gray-500 text-sm">Customized</p>
                                            <p id="order-is-customized" class="font-medium"></p>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <p class="text-gray-500 text-sm">Bulk Order</p>
                                            <p id="order-is-bulk" class="font-medium"></p>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <div class="flex gap-2 items-center">
                                                <p class="text-gray-500 text-sm">Designer</p>
                                                @if($order->designer)
                                                <span>
                                                    @livewire('report-button', [
                                                    'reporterClass' => auth()->user()->getMorphClassName(),
                                                    'reporterId' => auth()->user()->user_id,
                                                    'reportedClass' => $order->designer->getMorphClassName(),
                                                    'reportedId' => $order->designer->designer_id,
                                                    'orderId' => $order->order_id,
                                                    'entityName' => 'Designer'
                                                    ])
                                                </span>
                                                @endif
                                            </div>
                                            <p id="order-designer" class="font-medium"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment information -->
                                <div class="border-t border-gray-200 pt-4">
                                    <h3 class="font-inter font-bold text-lg mb-4">Payment Details</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <p class="text-gray-500 text-sm">Total Price</p>
                                            <p id="order-price" class="font-medium"></p>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <p class="text-gray-500 text-sm">Downpayment</p>
                                            <p id="order-downpayment" class="font-medium"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- ETA information if available -->
                                <div id="eta-container" class="border-t border-gray-200 pt-4 hidden">
                                    <h3 class="font-inter font-bold text-lg mb-4">Estimated Completion Date</h3>
                                    <div class="p-3 bg-gray-50 rounded-lg flex items-center">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-purple-100 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cPrimary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-gray-600 text-sm">Your order is expected to be completed by</p>
                                            <p id="order-eta" class="font-medium text-lg text-cPrimary"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cancellation information if available -->
                                <div id="cancellation-container" class="border-t border-gray-200 pt-4 hidden">
                                    <h3 class="font-inter font-bold text-lg mb-4">Cancellation Information</h3>
                                    <div class="p-3 bg-red-50 rounded-lg">
                                        <div class="flex items-start">
                                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-red-100 mr-3 flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-gray-700 text-sm font-medium">This order has been cancelled</p>
                                                <p class="text-gray-600 text-sm mt-1">Reason: <span id="cancellation-reason" class="font-medium"></span></p>
                                                <div id="cancellation-note-container" class="mt-2 text-sm bg-white p-3 rounded border border-red-200 hidden">
                                                    <p class="text-gray-600 font-medium">Additional notes:</p>
                                                    <p id="cancellation-note" class="text-gray-700 mt-1"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 pt-4">
                                    <h3 class="font-inter font-bold text-lg mb-4">Order Status Timeline</h3>
                                    <div id="order-timeline" class="relative ml-2">
                                        <!-- Timeline line -->
                                        <div class="absolute left-3.5 top-0 h-full w-0.5 bg-gray-200"></div>

                                        <!-- Status stages -->
                                        <div id="order-notifications" class="space-y-6 pb-4 relative max-h-[300px] overflow-y-auto pr-2 custom-scrollbar"></div>
                                    </div>
                                </div>

                                <div id="order-actions" class="flex flex-wrap gap-4 border-t border-gray-200 pt-4">
                                    <!-- Review button - only shows for completed orders -->
                                    <a id="review-button" href="#" class="hidden inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-cPrimary hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                                        Leave a Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="no-order-selected" class="bg-white rounded-lg shadow-sm">
                        <div class="flex flex-col items-center justify-center w-full p-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No order selected</h3>
                            <p class="mt-1 text-sm text-gray-500">Select an order from the list to view details</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @livewire('report-modal')
    </main>

    @include('layout.footer')

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        @media (max-width: 1024px) {
            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }
        }

        /* Fixed height for order panels */
        @media (min-width: 1024px) {

            #order-details,
            #no-order-selected {
                min-height: 400px;
                max-height: fit-content;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderButtons = document.querySelectorAll('.order-button');
            const orderDetails = document.getElementById('order-details');
            const noOrderSelected = document.getElementById('no-order-selected');
            const orderIdDisplay = document.getElementById('order-id-display');
            const orderStatusDetails = document.getElementById('order-status-details');
            const orderNotifications = document.getElementById('order-notifications');
            const closeDetails = document.getElementById('close-details');
            const orderSearch = document.getElementById('order-search');

            // New elements for order details
            const orderApparelType = document.getElementById('order-apparel-type');
            const orderProductionType = document.getElementById('order-production-type');
            const orderCompany = document.getElementById('order-company');
            const orderQuantity = document.getElementById('order-quantity');
            const orderIsCustomized = document.getElementById('order-is-customized');
            const orderIsBulk = document.getElementById('order-is-bulk');
            const orderPrice = document.getElementById('order-price');
            const orderDownpayment = document.getElementById('order-downpayment');
            const etaContainer = document.getElementById('eta-container');
            const orderEta = document.getElementById('order-eta');
            const orderDesigner = document.getElementById('order-designer');

            // Cancellation elements
            const cancellationContainer = document.getElementById('cancellation-container');
            const cancellationReason = document.getElementById('cancellation-reason');
            const cancellationNoteContainer = document.getElementById('cancellation-note-container');
            const cancellationNote = document.getElementById('cancellation-note');

            console.log('DOM elements loaded:', {
                orderDetails,
                orderNotifications,
                cancellationContainer,
                cancellationReason,
                cancellationNoteContainer,
            });

            orderDetails.classList.add('hidden');
            noOrderSelected.classList.remove('hidden');

            orderButtons.forEach(button => {
                button.addEventListener('click', function() {
                    orderButtons.forEach(btn => btn.classList.remove('border-cPrimary', 'bg-purple-50'));
                    this.classList.add('border-cPrimary', 'bg-purple-50');

                    const orderId = this.getAttribute('data-order-id');
                    const orderStatus = this.getAttribute('data-order-status');
                    const orderCreatedAt = new Date(this.getAttribute('data-order-created-at'));

                    // Get the additional order details
                    const quantity = this.getAttribute('data-order-quantity');
                    const productionType = this.getAttribute('data-order-production-type');
                    const apparelType = this.getAttribute('data-order-apparel-type');
                    const company = this.getAttribute('data-order-company');
                    const isCustomized = this.getAttribute('data-order-is-customized');
                    const isBulk = this.getAttribute('data-order-is-bulk');
                    const price = this.getAttribute('data-order-price');
                    const downpayment = this.getAttribute('data-order-downpayment');
                    const eta = this.getAttribute('data-order-eta');
                    const orderDesignerData = this.getAttribute('data-order-designer');

                    const formattedDate = orderCreatedAt.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                    });
                    const formattedTime = orderCreatedAt.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: 'numeric',
                    });

                    orderIdDisplay.textContent = orderId.substr(-6);
                    orderDetails.classList.remove('hidden');
                    noOrderSelected.classList.add('hidden');

                    // Set values for the additional fields
                    orderApparelType.textContent = apparelType;
                    orderProductionType.textContent = productionType;
                    orderCompany.textContent = company;
                    orderQuantity.textContent = quantity + ' item(s)';
                    orderIsCustomized.textContent = isCustomized;
                    orderIsBulk.textContent = isBulk;
                    orderPrice.textContent = parseFloat(price).toLocaleString('en-US', {
                        style: 'currency',
                        currency: 'PHP'
                    });
                    orderDownpayment.textContent = parseFloat(downpayment).toLocaleString('en-US', {
                        style: 'currency',
                        currency: 'PHP'
                    });
                    orderDesigner.textContent = orderDesignerData;

                    // Handle ETA display
                    if (eta && eta !== 'null') {
                        const etaDate = new Date(eta);
                        const formattedEta = etaDate.toLocaleDateString('en-US', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        orderEta.textContent = formattedEta;
                        etaContainer.classList.remove('hidden');
                    } else {
                        etaContainer.classList.add('hidden');
                    }

                    // Handle cancellation information display
                    console.log('Cancellation elements:', {
                        container: cancellationContainer,
                        reasonEl: cancellationReason,
                        noteContainer: cancellationNoteContainer,
                        noteEl: cancellationNote
                    });

                    const reason = this.getAttribute('data-order-cancellation-reason');
                    const note = this.getAttribute('data-order-cancellation-note');

                    const orderStatusId = this.getAttribute('data-order-status-id');
                    console.log('Cancellation data:', {
                        reason: reason,
                        note: note,
                        orderStatus: orderStatus,
                        statusId: orderStatusId
                    });

                    if (orderStatus === 'Cancelled' || orderStatusId === '8') {
                        console.log('Order is cancelled, showing cancellation info');
                        if (reason) {
                            cancellationReason.textContent = reason;
                            cancellationContainer.classList.remove('hidden');

                            if (reason === 'Other' && note) {
                                cancellationNote.textContent = note;
                                cancellationNoteContainer.classList.remove('hidden');
                            } else {
                                cancellationNoteContainer.classList.add('hidden');
                            }
                        } else {
                            cancellationReason.textContent = 'Not specified';
                            cancellationContainer.classList.remove('hidden');
                            cancellationNoteContainer.classList.add('hidden');
                        }
                    } else {
                        console.log('Order is not cancelled, hiding cancellation info');
                        cancellationContainer.classList.add('hidden');
                    }

                    // Show/hide review button based on order status
                    const reviewButton = document.getElementById('review-button');

                    // Check both status name and numeric ID (7 is completed)
                    if (orderStatus === 'Completed' || orderStatusId === '7') {
                        console.log('Showing review button for completed order:', orderId, 'Status ID:', orderStatusId);
                        reviewButton.classList.remove('hidden');
                        reviewButton.href = `/review/${orderId}`;
                    } else {
                        reviewButton.classList.add('hidden');
                    }

                    let statusColorClass = '';
                    if (orderStatus === 'Completed' || orderStatusId === '7') {
                        statusColorClass = 'bg-green-100 text-green-800';
                    } else if (orderStatus === 'Cancelled' || orderStatusId === '8') {
                        statusColorClass = 'bg-red-100 text-red-800';
                    } else {
                        statusColorClass = 'bg-blue-100 text-blue-800';
                    }

                    orderStatusDetails.innerHTML = `
                        <div class="flex flex-col md:flex-row md:justify-between gap-y-4 md:gap-y-0">
                            <div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColorClass}">
                                    ${orderStatus}
                                </span>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">Date Placed</p>
                                <p class="text-sm text-gray-600">${formattedDate} at ${formattedTime}</p>
                            </div>
                        </div>
                    `;

                    // Debug order data
                    console.log('Selected order:', {
                        id: orderId,
                        status: orderStatus,
                        statusId: orderStatusId,
                        cancellationReason: reason,
                        cancellationNote: note
                    });

                    // Make sure the notifications element exists
                    if (!orderNotifications) {
                        console.error('Order notifications element not found in the DOM');
                    }

                    // Parse notifications with error handling
                    let notifications = [];
                    try {
                        const notificationsData = this.getAttribute('data-order-notifications');
                        console.log('Notifications data:', notificationsData);

                        // Check if the data is empty or invalid JSON
                        if (notificationsData && notificationsData !== 'null' && notificationsData !== '[]') {
                            notifications = JSON.parse(notificationsData);
                            console.log('Parsed notifications:', notifications);
                        } else {
                            console.log('Empty notifications data or invalid JSON');
                            notifications = [];
                        }
                    } catch (error) {
                        console.error('Error parsing notifications:', error);
                        notifications = [];
                    }

                    let notificationsHTML = '';

                    // Create default status notification based on order status
                    const defaultStatusHTML = `
                        <div class="flex relative z-10">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-cPrimary border-2 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="bg-white rounded-lg border border-gray-200 p-3 shadow-sm">
                                    <p class="text-sm font-medium text-gray-900">Current Status: ${orderStatus}</p>
                                    <p class="text-xs text-gray-500 mt-1">${formattedDate} at ${formattedTime}</p>
                                </div>
                            </div>
                        </div>
                    `;

                    // Initialize empty notificationsHTML

                    if (notifications && notifications.length > 0) {
                        console.log('Notifications count:', notifications.length);
                        // Sort notifications by created_at date in descending order (newest first)
                        const sortedNotifications = [...notifications].sort((a, b) => {
                            return new Date(b.created_at) - new Date(a.created_at);
                        });

                        // Define status icons mapping
                        const statusIcons = {
                            'Order Received': `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>`,
                            'Design in Progress': `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>`,
                            'Finalize Order': `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>`,
                            'Awaiting Printing': `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>`,
                            'Printing in Progress': `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>`,
                            'Ready for Collection': `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>`,
                            'Completed': `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>`,
                            'Cancelled': `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>`,
                            'Default': `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>`
                        };

                        // Get color for status based on message
                        const getStatusColor = (message) => {
                            const lowercaseMsg = message.toLowerCase();
                            if (lowercaseMsg.includes('order received') || lowercaseMsg.includes('order placed')) {
                                return 'bg-blue-500';
                            } else if (lowercaseMsg.includes('design')) {
                                return 'bg-indigo-500';
                            } else if (lowercaseMsg.includes('finalize')) {
                                return 'bg-purple-500';
                            } else if (lowercaseMsg.includes('awaiting printing')) {
                                return 'bg-yellow-500';
                            } else if (lowercaseMsg.includes('printing in progress')) {
                                return 'bg-orange-500';
                            } else if (lowercaseMsg.includes('ready for collection')) {
                                return 'bg-green-500';
                            } else if (lowercaseMsg.includes('complet')) {
                                return 'bg-green-600';
                            } else if (lowercaseMsg.includes('cancel')) {
                                return 'bg-red-500';
                            } else {
                                return 'bg-gray-500';
                            }
                        };

                        // Get icon for status based on message
                        const getStatusIcon = (message) => {
                            const lowercaseMsg = message.toLowerCase();
                            if (lowercaseMsg.includes('order received') || lowercaseMsg.includes('order placed')) {
                                return statusIcons['Order Received'];
                            } else if (lowercaseMsg.includes('design')) {
                                return statusIcons['Design in Progress'];
                            } else if (lowercaseMsg.includes('finalize')) {
                                return statusIcons['Finalize Order'];
                            } else if (lowercaseMsg.includes('awaiting printing')) {
                                return statusIcons['Awaiting Printing'];
                            } else if (lowercaseMsg.includes('printing in progress')) {
                                return statusIcons['Printing in Progress'];
                            } else if (lowercaseMsg.includes('ready for collection')) {
                                return statusIcons['Ready for Collection'];
                            } else if (lowercaseMsg.includes('complet')) {
                                return statusIcons['Completed'];
                            } else if (lowercaseMsg.includes('cancel')) {
                                return statusIcons['Cancelled'];
                            } else {
                                return statusIcons['Default'];
                            }
                        };

                        // Add notifications to HTML
                        sortedNotifications.forEach((notification, index) => {
                            const notifDate = new Date(notification.created_at);
                            const formattedNotifDate = notifDate.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                            });
                            const formattedNotifTime = notifDate.toLocaleTimeString('en-US', {
                                hour: 'numeric',
                                minute: 'numeric',
                            });

                            const statusColor = getStatusColor(notification.message);
                            const statusIcon = getStatusIcon(notification.message);

                            notificationsHTML += `
                                <div class="flex relative z-10">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full ${statusColor} border-2 border-white">
                                            ${statusIcon}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="bg-white rounded-lg border border-gray-200 p-3 shadow-sm">
                                            <p class="text-sm font-medium text-gray-900">${notification.message}</p>
                                            <p class="text-xs text-gray-500 mt-1">${formattedNotifDate} at ${formattedNotifTime}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        // Add current status at the top of the timeline (before all notifications)
                        notificationsHTML = `
                            <div class="flex relative z-10">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-cPrimary border-2 border-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="bg-white rounded-lg border border-gray-200 p-3 shadow-sm">
                                        <p class="text-sm font-medium text-gray-900">Current Status: ${orderStatus}</p>
                                        <p class="text-xs text-gray-500 mt-1">Last updated: ${formattedDate} at ${formattedTime}</p>
                                    </div>
                                </div>
                            </div>
                        ` + notificationsHTML;
                    } else {
                        // If no notifications, add current status notification
                        notificationsHTML += defaultStatusHTML;
                    }

                    if (orderNotifications) {
                        console.log('Setting notifications HTML');
                        orderNotifications.innerHTML = notificationsHTML;
                    } else {
                        console.error('Cannot set notifications HTML - element not found');
                    }
                });
            });

            // Close details button (mobile)
            if (closeDetails) {
                closeDetails.addEventListener('click', function() {
                    orderDetails.classList.add('hidden');
                    noOrderSelected.classList.remove('hidden');
                    orderButtons.forEach(btn => btn.classList.remove('border-cPrimary', 'bg-purple-50'));
                });
            }

            // Search functionality
            if (orderSearch) {
                orderSearch.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();

                    orderButtons.forEach(button => {
                        const orderId = button.getAttribute('data-order-id').toLowerCase();
                        const orderStatus = button.getAttribute('data-order-status').toLowerCase();
                        const apparelType = button.getAttribute('data-order-apparel-type').toLowerCase();
                        const productionType = button.getAttribute('data-order-production-type').toLowerCase();
                        const company = button.getAttribute('data-order-company').toLowerCase();

                        if (orderId.includes(searchTerm) ||
                            orderStatus.includes(searchTerm) ||
                            apparelType.includes(searchTerm) ||
                            productionType.includes(searchTerm) ||
                            company.includes(searchTerm)) {
                            button.classList.remove('hidden');
                        } else {
                            button.classList.add('hidden');
                        }
                    });
                });
            }
        });
    </script>

</body>



</html>