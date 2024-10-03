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

    <div class="flex flex-row gap-y-2.5">
        <!-- LEFT HALF -->
        <form method="POST" action="{{ route('customer.checkout.post') }}" class="flex flex-col gap-y-[60px] px-[200px] py-[100px] w-[900px] h-[942]">
            @csrf

            <div class="flex flex-col gap-y-5">
                <div class="flex flex-col gap-y-3 w-[447px]">
                    <h1 class="font-gilroy font-bold text-5xl">Checkout</h1>
                    <h3 class="font-inter text-base">Before adding your item to the cart, take a moment to review your order to ensure everything is just the way you want it.</h3>
                </div>
            </div>

            <div class="flex flex-col gap-y-6">
                <div class="flex flex-col gap-y-4">
                    <h2 class="font-inter font-bold text-lg">Contact Number</h2>
                    <div class="flex flex-col gap-y-2">
                        <div class="flex flex-col gap-y-2.5 p-3 border border-black rounded-lg">
                            <input type="text" name="contact_number" class="font-inter text-base border-none focus:ring-0 outline-none w-full" placeholder="Enter contact number" value="{{ old('contact_number', $user->addressInformation->phone_number ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-y-6">
                    <div class="flex flex-col gap-y-4">
                        <h2 class="font-inter font-bold text-lg">Full Name</h2>
                        <div class="flex flex-col gap-y-2">
                            <div class="flex flex-col gap-y-2.5 p-3 border border-black rounded-lg">
                                <input type="text" name="name" class="font-inter text-base border-none focus:ring-0 outline-none w-full" placeholder="Enter full name" value="{{ old('name', $user->name ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-y-4">
                        <h2 class="font-inter font-bold text-lg">Address</h2>
                        <div class="flex flex-col gap-y-2">
                            <div class="flex flex-col gap-y-2.5 p-3 border border-black rounded-lg">
                                <input type="text" name="address" class="font-inter text-base border-none focus:ring-0 outline-none w-full" placeholder="Enter your address" value="{{ old('address', $user->addressInformation->address ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row gap-x-6 justify-between">
                        <div class="flex flex-col gap-y-4">
                            <h2 class="font-inter font-bold text-lg">State/Province</h2>
                            <div class="flex flex-col gap-y-2">
                                <div class="flex flex-col gap-y-2.5 p-3 border border-black rounded-lg w-[184px]">
                                    <input type="text" name="state" class="font-inter text-base border-none focus:ring-0 outline-none w-full" placeholder="Enter your state/province" value="{{ old('state', $user->addressInformation->state ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-y-4">
                            <h2 class="font-inter font-bold text-lg">City</h2>
                            <div class="flex flex-col gap-y-2">
                                <div class="flex flex-col gap-y-2.5 p-3 border border-black rounded-lg w-[184px]">
                                    <input type="text" name="city" class="font-inter text-base border-none focus:ring-0 outline-none w-full" placeholder="Enter your city" value="{{ old('city', $user->addressInformation->city ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-y-4">
                            <h2 class="font-inter font-bold text-lg">Zip Code</h2>
                            <div class="flex flex-col gap-y-2">
                                <div class="flex flex-col gap-y-2.5 p-3 border border-black rounded-lg w-[184px]">
                                    <input type="text" name="zip_code" class="font-inter text-base border-none focus:ring-0 outline-none w-full" placeholder="Enter your zip code" value="{{ old('zip_code', $user->addressInformation->zip_code ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (session('error'))
            <div class="flex flex-col gap-y-2.5">
                <div class="flex flex-col gap-y-2.5 px-6 py-3.5 rounded-lg bg-[rgba(255,0,0,0.1)]">
                    <h2 class="font-inter text-lg text-[rgba(255,0,0,0.5)]">{{ session('error') }}</h2>
                </div>
            </div>
            @endif

            <div class="flex flex-row gap-x-3 h-[50px]">
                <div class="flex flex-col gap-y-2.5 px-6 py-3.5 rounded-lg bg-[rgba(156,163,175,0.21)]">
                    <h2 class="font-inter text-lg text-[rgba(0,0,0,0.5)]">Cancel</h2>
                </div>
                <div class="flex flex-col gap-y-2.5">
                    <button type="submit" class="bg-cPrimary rounded-xl text-white px-6 py-3">Checkout</button>
                </div>
            </div>
        </form>

        <!-- RIGHT HALF -->
        <div class="flex flex-col px-[30px] py-[100px] flex-grow bg-[rgba(214,159,251,0.1)]">
            @foreach ($cartItems as $cartItem)
            <div class="flex flex-col gap-y-2">
                <div class="flex flex-col gap-y-8 py-6">
                    <div class="flex flex-row gap-x-5 items-start justify-start">
                        <div class="flex flex-col gap-y-4 px-6 py-6 border border-black rounded-lg bg-[#F3F3F3] w-[100px] h-[120px] items-center justify-center">
                            <img src="{{ asset('storage/' . $cartItem->cartItemImages[0]->image) }}" alt="Apparel Image" class="">
                        </div>
                        <div class="flex flex-col gap-y-2 flex-grow text-base">
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter">Apparel Selected:</h2>
                                <h2 class="font-inter font-bold">{{ $cartItem->apparelType->name }}</h2>
                            </div>
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter">Production Company:</h2>
                                <h2 class="font-inter font-bold">{{ $cartItem->productionCompany->company_name }}</h2>
                            </div>
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter ">Production Type:</h2>
                                <h2 class="font-inter font-bold">{{ $cartItem->productionType->name }}</h2>
                            </div>
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter ">Order Type:</h2>
                                <h2 class="font-inter font-bold">{{ ucfirst($cartItem->orderType) }}</h2>
                            </div>
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter ">Customization:</h2>
                                <h2 class="font-inter font-bold">{{ ucfirst($cartItem->customization) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-1 ml-auto items-end">
                        <h2 class="font-gilroy font-bold text-2xl text-cPrimary">{{ $cartItem->price }} PHP</h2>
                        <div class="flex flex-row gap-y-2.5">
                            <a href="{{ route('customer.checkout.delete', ['cartItemId' => $cartItem->cart_item_id]) }}" class="font-gilroy font-bold text-base text-cAccent">Remove</a>
                        </div>
                    </div>
                </div>
                <hr class="mb-5">
            </div>
            @endforeach

            <div class="flex flex-col gap-y-1">
                <div class="flex flex-row justify-between">
                    <h2 class="font-gilroy font-bold text-[30px]">Total</h2>
                    <h2 class="font-gilroy font-bold text-[30px]">{{ number_format($cartItems->sum('price'), 2) }} PHP</h2>
                </div>
                <div class="flex flex-col gap-y-2.5">
                    <h3 class="font-inter text-sm text-gray-500">Please note that this payment serves as a down payment to secure the services of the production company and designers. The remaining balance will be due once your order is completed.</h3>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>