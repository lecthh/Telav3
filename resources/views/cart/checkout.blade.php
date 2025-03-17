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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="font-gilroy font-bold text-3xl md:text-4xl text-gray-900 mb-2">Checkout</h1>
        <p class="text-gray-600 mb-10">Complete your purchase by providing your shipping details</p>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- LEFT HALF - Customer Information -->
            <div class="flex-1">
                <form method="POST" action="{{ route('customer.checkout.post') }}" class="bg-white rounded-lg shadow-sm p-6 md:p-8">
                    @csrf

                    <!-- Contact Section -->
                    <div class="mb-8">
                        <h2 class="font-inter font-bold text-xl text-gray-900 mb-6">Contact Information</h2>

                        <div class="mb-6">
                            <label for="name" class="block font-medium text-gray-700 mb-2">Full Name</label>
                            <div class="relative rounded-md shadow-sm border border-gray-300 focus-within:border-cPrimary focus-within:ring-1 focus-within:ring-cPrimary">
                                <input type="text" name="name" id="name" class="block w-full px-4 py-3 focus:outline-none rounded-md" placeholder="Enter your full name" value="{{ old('name', $user->name ?? '') }}">
                            </div>
                        </div>

                        <div>
                            <label for="contact_number" class="block font-medium text-gray-700 mb-2">Contact Number</label>
                            <div class="relative rounded-md shadow-sm border border-gray-300 focus-within:border-cPrimary focus-within:ring-1 focus-within:ring-cPrimary">
                                <input type="text" name="contact_number" id="contact_number" class="block w-full px-4 py-3 focus:outline-none rounded-md" placeholder="Enter contact number" value="{{ old('contact_number', $user->addressInformation->phone_number ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Section -->
                    <div>
                        <h2 class="font-inter font-bold text-xl text-gray-900 mb-6">Shipping Address</h2>

                        <div class="mb-6">
                            <label for="address" class="block font-medium text-gray-700 mb-2">Street Address</label>
                            <div class="relative rounded-md shadow-sm border border-gray-300 focus-within:border-cPrimary focus-within:ring-1 focus-within:ring-cPrimary">
                                <input type="text" name="address" id="address" class="block w-full px-4 py-3 focus:outline-none rounded-md" placeholder="Enter your address" value="{{ old('address', $user->addressInformation->address ?? '') }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                            <div>
                                <label for="city" class="block font-medium text-gray-700 mb-2">City</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300 focus-within:border-cPrimary focus-within:ring-1 focus-within:ring-cPrimary">
                                    <input type="text" name="city" id="city" class="block w-full px-4 py-3 focus:outline-none rounded-md" placeholder="Enter your city" value="{{ old('city', $user->addressInformation->city ?? '') }}">
                                </div>
                            </div>

                            <div>
                                <label for="state" class="block font-medium text-gray-700 mb-2">State/Province</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300 focus-within:border-cPrimary focus-within:ring-1 focus-within:ring-cPrimary">
                                    <input type="text" name="state" id="state" class="block w-full px-4 py-3 focus:outline-none rounded-md" placeholder="Enter your state" value="{{ old('state', $user->addressInformation->state ?? '') }}">
                                </div>
                            </div>

                            <div>
                                <label for="zip_code" class="block font-medium text-gray-700 mb-2">Zip Code</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300 focus-within:border-cPrimary focus-within:ring-1 focus-within:ring-cPrimary">
                                    <input type="text" name="zip_code" id="zip_code" class="block w-full px-4 py-3 focus:outline-none rounded-md" placeholder="Enter your zip code" value="{{ old('zip_code', $user->addressInformation->zip_code ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (session('error'))
                    <div class="mt-6 bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">{{ session('error') }}</h3>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mt-8 flex flex-col sm:flex-row gap-4 sm:justify-between">
                        <a href="{{ route('customer.cart') }}" class="inline-flex justify-center py-3 px-6 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            Back to Cart
                        </a>
                        <button type="submit" class="inline-flex justify-center py-3 px-8 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-cPrimary hover:bg-cPrimary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            Complete Order
                        </button>
                    </div>
                </form>
            </div>

            <!-- RIGHT HALF - Order Summary -->
            <div class="w-full lg:w-[400px]">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
                    </div>

                    <div class="px-6 py-4 max-h-[500px] overflow-y-auto">
                        @foreach ($cartItems as $cartItem)
                        <div class="py-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                            <div class="flex gap-4">
                                <!-- Image -->
                                <div class="w-16 h-16 flex-shrink-0 rounded-md border border-gray-200 overflow-hidden">
                                    @if($cartItem->cartItemImages->isNotEmpty())
                                    <img src="{{ asset('storage/' . $cartItem->cartItemImages[0]->image) }}" alt="Apparel Image" class="w-full h-full object-contain">
                                    @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    @endif
                                </div>

                                <!-- Details -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $cartItem->apparelType->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $cartItem->productionCompany->company_name }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $cartItem->quantity }}</p>
                                </div>

                                <!-- Price -->
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ number_format($cartItem->downpayment, 2) }} PHP</p>
                                    <p class="text-xs text-gray-500">Downpayment</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 px-6 py-4">
                        <div class="flex justify-between text-sm">
                            <p class="text-gray-600">Subtotal</p>
                            <p class="font-medium text-gray-900">{{ number_format($cartItems->sum('total_price'), 2) }} PHP</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 px-6 py-4">
                        <div class="flex justify-between text-base">
                            <p class="font-medium text-gray-900">Downpayment (50%)</p>
                            <p class="font-bold text-cPrimary">{{ number_format($cartItems->sum('downpayment'), 2) }} PHP</p>
                        </div>
                        <div class="mt-2 p-3 bg-blue-50 rounded-md">
                            <p class="text-xs text-blue-700">
                                <svg class="inline-block h-4 w-4 mr-1 -mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                You'll only be charged the downpayment amount now. The remaining balance will be due once your order is completed.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>