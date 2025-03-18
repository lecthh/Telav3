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

<body class="flex flex-col justify-between min-h-screen bg-gray-50">
    <div class="flex flex-col">
        @include('layout.nav')

        <div class="px-4 sm:px-6 lg:px-8 py-12 max-w-7xl mx-auto w-full">
            <!-- Header -->
            <div class="mb-10">
                <h1 class="font-gilroy font-bold text-4xl text-gray-900">Your Cart</h1>
                <p class="mt-2 text-gray-600">Review your items before checkout</p>
            </div>

            @if($cartItems->isEmpty())
            <!-- Empty cart state -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Your cart is empty</h3>
                <p class="mt-1 text-gray-500">Looks like you haven't added any items to your cart yet.</p>
                <div class="mt-6">
                    <a href="{{ route('customer.place-order.select-apparel') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-cPrimary hover:bg-cPrimary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                        Start Shopping
                    </a>
                </div>
            </div>
            @else

            <form action="{{ route('customer.cart.post') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items (Left Column) -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-medium text-gray-900">Items ({{ $cartItems->count() }})</h2>
                            </div>

                            <div class="divide-y divide-gray-200">
                                @foreach ($cartItems as $cartItem)
                                <div class="p-6">
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        <!-- Checkbox -->
                                        <div class="flex items-start sm:items-center">
                                            <input type="checkbox"
                                                id="cart_item_{{ $cartItem->cart_item_id }}"
                                                name="cart_items[]"
                                                value="{{ $cartItem->cart_item_id }}"
                                                data-price="{{ $cartItem->price }}"
                                                data-quantity="{{ $cartItem->quantity }}"
                                                data-downpayment="{{ $cartItem->downpayment ?? ($cartItem->price * $cartItem->quantity / 2) }}"
                                                class="cart-checkbox h-5 w-5 rounded border-gray-300 text-cPrimary focus:ring-cPrimary">
                                        </div>

                                        <!-- Image -->
                                        <div class="w-24 h-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-gray-100 flex items-center justify-center">
                                            @if($cartItem->cartItemImages->isNotEmpty())
                                            <img src="{{ asset('storage/' . $cartItem->cartItemImages->first()->image) }}" alt="{{ $cartItem->apparelType->name }}" class="h-full w-full object-contain object-center">
                                            @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            @endif
                                        </div>

                                        <!-- Details -->
                                        <div class="flex-1">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <h3 class="text-base font-medium text-gray-900">{{ $cartItem->apparelType->name }}</h3>
                                                    <p class="mt-1 text-sm text-gray-500">{{ $cartItem->productionCompany->company_name }}</p>
                                                    <p class="mt-1 text-sm text-gray-500">{{ $cartItem->productionType->name }}</p>
                                                </div>

                                                <div>
                                                    <div class="flex justify-between text-sm mb-1">
                                                        <span class="text-gray-600">Order Type:</span>
                                                        <span class="font-medium">{{ ucfirst($cartItem->orderType) }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-sm mb-1">
                                                        <span class="text-gray-600">Customization:</span>
                                                        <span class="font-medium">{{ ucfirst($cartItem->customization) }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">Quantity:</span>
                                                        <span class="font-medium">{{ $cartItem->quantity }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="text-right">
                                            <div class="text-lg font-medium text-cPrimary">
                                                {{ number_format($cartItem->downpayment > 0 ? $cartItem->downpayment : ($cartItem->price * $cartItem->quantity / 2), 2) }} PHP
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">Downpayment (50%)</p>
                                            <a href="{{ route('customer.remove-cart-item', ['cartItemId' => $cartItem->cart_item_id]) }}" class="mt-2 inline-block text-sm font-medium text-red-600 hover:text-red-500">
                                                Remove
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary (Right Column) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden sticky top-24">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
                            </div>

                            <div class="px-6 py-6">
                                <div class="flex justify-between mb-4">
                                    <span class="text-base text-gray-600">Subtotal</span>
                                    <span class="text-base font-medium text-gray-900">{{ number_format($cartItems->sum('total_price'), 2) }} PHP</span>
                                </div>

                                <div class="flex justify-between mb-2">
                                    <span class="text-base text-gray-600">Downpayment (50%)</span>
                                    <span id="totalPrice" class="text-base font-medium text-gray-900">{{ number_format($cartItems->sum('downpayment'), 2) }} PHP</span>
                                </div>

                                <p class="text-xs text-gray-500 mb-6">This amount represents the downpayment (50% of total price). The remaining balance will be due upon completion.</p>

                                <div class="border-t border-gray-200 pt-6">
                                    <button type="submit" class="w-full bg-cPrimary text-white px-6 py-3 rounded-md font-medium hover:bg-cPrimary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary transition-colors">
                                        Proceed to Checkout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>

    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            const totalPriceElement = document.getElementById('totalPrice');
            let totalPrice = 0;

            console.log('Cart checkboxes found:', checkboxes.length);

            checkboxes.forEach(checkbox => {
                checkbox.checked = true;

                // Add the downpayment to total for checked items
                if (checkbox.checked) {
                    // Get downpayment from data attribute with fallback calculation
                    const price = parseFloat(checkbox.dataset.price) || 0;
                    const quantity = parseInt(checkbox.dataset.quantity) || 1;
                    const downpayment = parseFloat(checkbox.dataset.downpayment) || (price * quantity / 2);

                    console.log('Item values:', {
                        id: checkbox.value,
                        price: price,
                        quantity: quantity,
                        downpayment: downpayment
                    });

                    totalPrice += downpayment;
                }

                checkbox.addEventListener('change', function() {
                    const price = parseFloat(this.dataset.price) || 0;
                    const quantity = parseInt(this.dataset.quantity) || 1;
                    const downpayment = parseFloat(this.dataset.downpayment) || (price * quantity / 2);

                    if (this.checked) {
                        totalPrice += downpayment;
                    } else {
                        totalPrice -= downpayment;
                    }

                    console.log('Total updated:', totalPrice);
                    totalPriceElement.textContent = totalPrice.toFixed(2) + ' PHP';
                });
            });

            // Set initial total price display
            console.log('Initial total:', totalPrice);
            totalPriceElement.textContent = totalPrice.toFixed(2) + ' PHP';
        });
    </script>
</body>

</html>