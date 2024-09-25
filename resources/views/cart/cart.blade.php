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

<body>
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
    <div class="flex flex-row gap-x-8 items-center">
        <input type="checkbox" class="cart-checkbox" name="cart_items[]" value="{{ $cartItem->cart_item_id }}" data-price="{{ $cartItem->price }}">

        <div class="flex flex-col gap-y-4 px-5 py-5 border border-black rounded-lg bg-[#F3F3F3]">
            <div class="flex flex-col gap-y-2 5 p-x-2.5 p-y-2.5">
            <img src="{{ asset('storage/' . $cartItem->cartItemImages->first()->image) }}" alt="Apparel Image" class="w-full h-auto">

            </div>
        </div>
        <div class="flex flex-col gap-y-2 flex-grow">
            <div class="flex flex-row justify-between">
                <h2 class="font-inter text-lg">Apparel Selected:</h2>
                <h2 class="font-inter font-bold text-lg">{{ $cartItem->apparelType->name }}</h2>
            </div>
            <div class="flex flex-row justify-between">
                <h2 class="font-inter text-lg">Production Company:</h2>
                <h2 class="font-inter font-bold text-lg">{{ $cartItem->productionCompany->company_name }}</h2>
            </div>
            <div class="flex flex-row justify-between">
                <h2 class="font-inter text-lg">Production Type:</h2>
                <h2 class="font-inter font-bold text-lg">{{ $cartItem->productionType->name }}</h2>
            </div>
            <div class="flex flex-row justify-between">
                <h2 class="font-inter text-lg">Order Type:</h2>
                <h2 class="font-inter font-bold text-lg">{{ ucfirst($cartItem->orderType) }}</h2>
            </div>
            <div class="flex flex-row justify-between">
                <h2 class="font-inter text-lg">Customization:</h2>
                <h2 class="font-inter font-bold text-lg">{{ ucfirst($cartItem->customization) }}</h2>
            </div>
        </div>
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