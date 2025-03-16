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
                                data-order-created-at="{{ $order->created_at }}"
                                data-order-notifications='@json($order->notifications)'>
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

                                <div class="border-t border-gray-200 pt-4">
                                    <h3 class="font-inter font-bold text-lg mb-4">Order Status Timeline</h3>
                                    <div id="order-notifications" class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar"></div>
                                </div>

                                <div class="flex flex-wrap gap-4 border-t border-gray-200 pt-4">
                                    <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                                        Contact Support
                                    </button>
                                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-cPrimary hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                                        Track Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
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

            // IMPORTANT FIX: Initialize the view with only the placeholder showing, but never both panels
            orderDetails.classList.add('hidden');
            noOrderSelected.classList.remove('hidden');

            // Handle order selection
            orderButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Highlight selected order
                    orderButtons.forEach(btn => btn.classList.remove('border-cPrimary', 'bg-purple-50'));
                    this.classList.add('border-cPrimary', 'bg-purple-50');

                    // Extract order data
                    const orderId = this.getAttribute('data-order-id');
                    const orderStatus = this.getAttribute('data-order-status');
                    const orderCreatedAt = new Date(this.getAttribute('data-order-created-at'));
                    const formattedDate = orderCreatedAt.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                    });
                    const formattedTime = orderCreatedAt.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: 'numeric',
                    });

                    // CRITICAL: Show details and ALWAYS hide the placeholder
                    orderIdDisplay.textContent = orderId.substr(-6);
                    orderDetails.classList.remove('hidden');
                    noOrderSelected.classList.add('hidden');

                    // Set up status with appropriate color
                    let statusColorClass = '';
                    if (orderStatus === 'Completed') {
                        statusColorClass = 'bg-green-100 text-green-800';
                    } else if (orderStatus === 'Cancelled') {
                        statusColorClass = 'bg-red-100 text-red-800';
                    } else {
                        statusColorClass = 'bg-blue-100 text-blue-800';
                    }

                    // Populate the order status details
                    orderStatusDetails.innerHTML = `
                        <div class="flex flex-col md:flex-row md:justify-between gap-y-4 md:gap-y-0">
                            <div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColorClass}">
                                    ${orderStatus}
                                </span>
                                <p class="mt-2 text-sm text-gray-600">Order is being processed</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">Date Placed</p>
                                <p class="text-sm text-gray-600">${formattedDate} at ${formattedTime}</p>
                            </div>
                        </div>
                    `;

                    // Populate the notifications/timeline
                    const notifications = JSON.parse(this.getAttribute('data-order-notifications'));
                    let notificationsHTML = '';

                    if (notifications && notifications.length > 0) {
                        notifications.forEach((notification, index) => {
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

                            notificationsHTML += `
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full ${index === 0 ? 'bg-cPrimary' : 'bg-gray-200'}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ${index === 0 ? 'text-white' : 'text-gray-600'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4 mb-6">
                                        <p class="text-sm font-medium text-gray-900">${notification.message}</p>
                                        <p class="text-xs text-gray-500 mt-1">${formattedNotifDate} at ${formattedNotifTime}</p>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        notificationsHTML = '<p class="text-sm text-gray-500">No updates available for this order.</p>';
                    }

                    orderNotifications.innerHTML = notificationsHTML;
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

                        if (orderId.includes(searchTerm) || orderStatus.includes(searchTerm)) {
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