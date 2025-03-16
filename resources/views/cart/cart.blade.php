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

<body class="flex flex-col justify-between h-screen">
    <div class="flex flex-col">
        @include('layout.nav')
        <form action="{{ route('customer.cart.post') }}" method="POST">
            @csrf
            <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px]">
                <div class="flex flex-col gap-y-6">
                    <div class="flex flex-col gap-y-3">
                        <h1 class="font-gilroy font-bold text-5xl">Cart</h1>
                    </div>
                </div>

                <div class="flex flex-col gap-y-[60px]">
                    @if($cartItems->isEmpty())
                    <p>Your cart is empty.</p>
                    @else
                    @foreach ($cartItems as $cartItem)
                    <div class="flex flex-row gap-x-8 items-start">
                        <input type="checkbox" id="cart_item_{{ $cartItem->cart_item_id }}" name="cart_items[]" value="{{ $cartItem->cart_item_id }}" data-price="{{ $cartItem->price }}" class="cart-checkbox border border-black w-4 h-4 p-1 py-1 rounded checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary">
                        <label for="cart_item_{{ $cartItem->cart_item_id }}" class="flex gap-x-4 justify-between w-full">
                            <div class="flex flex-col gap-y-4 px-5 py-5 border border-black rounded-lg bg-[#F3F3F3] items-center justify-center">
                                <div class="flex flex-col gap-y-2 p-2 w-[120px] h-[100px] justify-center">
                                    @if($cartItem->cartItemImages->isNotEmpty())
                                        <img src="{{ asset('storage/' . $cartItem->cartItemImages->first()->image) }}" alt="Apparel Image" class="w-full h-auto">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500 text-xs text-center">
                                            No image available
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col gap-y-2 flex-grow">
                                <div class="flex flex-row justify-between">
                                    <h2 class="font-inter text-base">Apparel Selected:</h2>
                                    <h2 class="font-inter font-bold text-base">{{ $cartItem->apparelType->name }}</h2>
                                </div>
                                <div class="flex flex-row justify-between">
                                    <h2 class="font-inter text-base">Production Company:</h2>
                                    <h2 class="font-inter font-bold text-base">{{ $cartItem->productionCompany->company_name }}</h2>
                                </div>
                                <div class="flex flex-row justify-between">
                                    <h2 class="font-inter text-base">Production Type:</h2>
                                    <h2 class="font-inter font-bold text-base">{{ $cartItem->productionType->name }}</h2>
                                </div>
                                <div class="flex flex-row justify-between">
                                    <h2 class="font-inter text-base">Order Type:</h2>
                                    <h2 class="font-inter font-bold text-base">{{ ucfirst($cartItem->orderType) }}</h2>
                                </div>
                                <div class="flex flex-row justify-between">
                                    <h2 class="font-inter text-base">Customization:</h2>
                                    <h2 class="font-inter font-bold text-base">{{ ucfirst($cartItem->customization) }}</h2>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="flex flex-col gap-y-1 ml-auto items-end">
                        <h2 class="font-gilroy font-bold text-2xl text-cPrimary">{{ $cartItem->price }} PHP</h2>
                        <div class="flex flex-row gap-y-2.5">
                            <a href="{{ route('customer.remove-cart-item', ['cartItemId' => $cartItem->cart_item_id]) }}" class="font-gilroy font-bold text-base text-cAccent">Remove</a>
                        </div>
                    </div>
                    <hr>
                    @endforeach

                    @endif
                </div>

                <div class="flex flex-row justify-between">
                    <h2 class="font-gilroy font-bold text-[30px]">Total</h2>
                    <h2 id="totalPrice" class="font-gilroy font-bold text-[30px]">0 PHP</h2>
                </div>

                <div class="flex flex-col gap-y-2.5">
                    <div class="flex flex-col gap-y-2.5 py-3.5 items-start">
                        <button type="submit" class="bg-cPrimary text-white px-6 py-2 rounded-xl">Checkout</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('layout.footer')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            const totalPriceElement = document.getElementById('totalPrice');
            let totalPrice = 0;

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const itemPrice = parseFloat(this.dataset.price);

                    if (this.checked) {
                        totalPrice += itemPrice;
                    } else {
                        totalPrice -= itemPrice;
                    }

                    totalPriceElement.textContent = totalPrice.toFixed(2) + ' PHP';
                });
            });
        });
    </script>    
</body>

</html>