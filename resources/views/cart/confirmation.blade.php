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

<body class="bg-gray-50">
    @include('layout.nav')

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <!-- Success Header with Animation -->
            <div class="bg-gradient-to-r from-cPrimary/90 to-cPrimary p-8 text-center">
                <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-white text-cPrimary mb-6 animate-bounce-slow">
                    @include('svgs.check')
                </div>
                <h1 class="font-gilroy font-bold text-3xl text-white">Order Confirmed!</h1>
                <p class="text-white/80 mt-2 text-lg">Thank you for your payment</p>
            </div>

            <div class="p-8">
                <!-- Order Details -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h2 class="font-gilroy font-medium text-xl text-gray-900 mb-4">Order Details</h2>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                            <span class="text-gray-600">Order Number:</span>
                            <span class="font-medium text-gray-900">{{ $order->order_id }}</span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                            <span class="text-gray-600">Order Date:</span>
                            <span class="font-medium text-gray-900">{{ $order->created_at->format('F d, Y') }}</span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                            <span class="text-gray-600">Payment Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Downpayment Paid
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Order Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Processing
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="mb-8">
                    <h2 class="font-gilroy font-medium text-xl text-gray-900 mb-4">What's Next?</h2>

                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1 md:flex md:justify-between">
                            <p class="text-sm text-blue-700">
                                Our design team is now working on your order. You'll receive a draft design for your review soon.
                            </p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <ol class="relative border-l border-gray-200 ml-3 space-y-8">
                            <li class="mb-6 ml-6">
                                <span class="absolute flex items-center justify-center w-8 h-8 bg-green-100 rounded-full -left-4 ring-4 ring-white">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <h3 class="font-medium leading-tight text-gray-900">Order Placed</h3>
                                <p class="text-sm text-gray-500">Your order has been received and downpayment processed</p>
                            </li>

                            <li class="mb-6 ml-6">
                                <span class="absolute flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full -left-4 ring-4 ring-white">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <h3 class="font-medium leading-tight text-gray-900">Design in Progress</h3>
                                <p class="text-sm text-gray-500">Our designers are working on your custom design</p>
                            </li>

                            <li class="mb-6 ml-6">
                                <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -left-4 ring-4 ring-white">
                                    <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <h3 class="font-medium leading-tight text-gray-900">Review & Approval</h3>
                                <p class="text-sm text-gray-500">You'll review and approve the design</p>
                            </li>

                            <li class="ml-6">
                                <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -left-4 ring-4 ring-white">
                                    <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                    </svg>
                                </span>
                                <h3 class="font-medium leading-tight text-gray-900">Final Production & Delivery</h3>
                                <p class="text-sm text-gray-500">Production begins after approval and balance payment</p>
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    <a href="{{ route('customer.profile.orders') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-cPrimary bg-cPrimary/10 hover:bg-cPrimary/20">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        View My Orders
                    </a>

                    <a href="{{ route('home') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-cPrimary hover:bg-cPrimary/90">
                        Continue Shopping
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')

    <style>
        .animate-bounce-slow {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(-5%);
                animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
            }

            50% {
                transform: translateY(0);
                animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
            }
        }
    </style>
</body>

</html>