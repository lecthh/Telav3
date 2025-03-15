<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css " rel="stylesheet" />
    @vite('resources/css/app.css')
</head>
@include('layout.nav')
<form action="{{ route('customer.place-order.review-post',['apparel'=> $apparel, 'productionType' => $productionType, 'company' => $company]) }}" method="post">
    @csrf

    <body class="flex flex-col h-screen justify-between">
        <div class="font-inter bg-white flex flex-col px-[200px] py-[100px] gap-y-[60px]">
            <div class="flex flex-col gap-y-10">
                @include('customer.place-order.steps')
                <div class="flex flex-col gap-y-3 animate-fade-in">
                    <h1 class="font-gilroy font-bold text-5xl">Review Your Order</h1>
                    <p class="font-inter text-base">Before adding your item to the cart, take a moment to review your order to ensure everything is just the way you want it.</p>
                </div>
            </div>
            <div class="flex flex-col gap-y-10 font-inter animate-fade-in">
                <div class="flex flex-col gap-y-3">
                    <div class="flex flex-col gap-y-3">
                        <h3 class="font-bold">Production Company</h3>
                        <div class="flex gap-x-4 p-4 bg-cGrey rounded-md">
                            <div class="w-[168px] h-[100px] rounded-md bg-cPrimary">
                                <img src="{{ asset($productionCompany->company_logo) }}" alt="{{ $productionCompany->company_name }}" class="object-contain w-full h-full">
                            </div>
                            <div class="flex flex-col gap-y-2">
                                <div class="flex flex-col gap-y-1">
                                    <h4 class="font-gilroy font-bold text-base">{{ $productionCompany->company_name }}</h4>
                                    <h3 class="font-gilroy font-bold text-2xl">{{ number_format($orderPrice, 2) }} PHP</h3>
                                    <p class="text-sm text-gray-600">{{ $customization['order_type'] === 'bulk' ? 'Bulk' : 'Base' }} price per item</p>
                                </div>
                                <a href="#" class="font-inter text-base text-cPrimary hover:underline">View Sample</a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-cPrimary">

                <div class="flex flex-col gap-y-3 text-lg">
                    <div class="flex justify-between">
                        <h3>Apparel Selected:</h3>
                        <h3 class="font-bold">{{ $apparelName }}</h3>
                    </div>
                    <div class="flex justify-between">
                        <h3>Production Type:</h3>
                        <h3 class="font-bold">{{ $productionTypeName }}</h3>
                    </div>
                    <div class="flex justify-between">
                        <h3>Order Type:</h3>
                        <h3 class="font-bold">{{ ucfirst($customization['order_type']) }}</h3>
                    </div>
                    <div class="flex justify-between">
                        <h3>Customization:</h3>
                        <h3 class="font-bold">{{ ucfirst($customization['custom_type']) }}</h3>
                    </div>
                </div>

                <hr class="border-cPrimary">
                <div class="flex gap-x-10">
                    <div class="flex border w-[400px] h-[200px] rounded-md border-cPrimary bg-white">
                        @if($canvasImage)
                        <img src="{{ $canvasImage }}" alt="canvasDesign" class="object-cover w-full h-full rounded-md">
                        @else
                        <p>No design available.</p>
                        @endif
                    </div>
                </div>

                <hr class="border-cPrimary">
                <div class="flex gap-x-10">
                    @foreach ($customization['media'] as $media)
                    <div class="flex border w-[168px] h-[132px] rounded-md border-cPrimary bg-white">
                        <img src="{{ asset('storage/' . $media) }}" alt="Design" class="object-cover w-full h-full rounded-md">
                    </div>
                    @endforeach
                </div>

                <div class="flex flex-col gap-y-3">
                    <h3 class="text-lg font-bold">Description</h3>
                    <h5 class="text-base">{{ $customization['description'] }}</h5>
                </div>

                <div class="flex flex-col gap-y-6 p-6 border border-gray-200 rounded-lg bg-gray-50">
                    <h3 class="text-lg font-bold">Order Summary</h3>

                    <div class="flex flex-col gap-y-3 text-base">
                        <div class="flex justify-between">
                            <span>Unit Price:</span>
                            <span class="font-semibold">{{ number_format($orderPrice, 2) }} PHP</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Quantity:</span>
                            <span class="font-semibold">{{ $quantity }} {{ $quantity > 1 ? 'items' : 'item' }}</span>
                        </div>

                        @if($customization['order_type'] === 'bulk' && $basePrice > $bulkPrice)
                        <div class="flex justify-between text-cPrimary text-sm">
                            <span>Bulk discount applied</span>
                            <span>-{{ number_format(($basePrice - $bulkPrice) * $quantity, 2) }} PHP</span>
                        </div>
                        @endif

                        <hr class="border-gray-300 my-2">

                        <div class="flex justify-between text-lg">
                            <span class="font-bold">Estimated Total:</span>
                            <span class="font-bold">{{ number_format($totalPrice, 2) }} PHP</span>
                        </div>

                        <div class="flex justify-between text-base mt-1">
                            <span>Required Downpayment (50%):</span>
                            <span class="font-semibold">{{ number_format($totalPrice / 2, 2) }} PHP</span>
                        </div>

                        @if($customization['order_type'] === 'bulk')
                        <p class="text-sm text-gray-600 mt-2">*Minimum bulk order quantity is 10 items</p>
                        @endif

                        <p class="text-sm text-gray-600">*Final price may be adjusted based on design customization details</p>
                    </div>
                </div>

                <div class=" flex justify-start gap-x-3">
                    <a href="{{ route('customer.place-order.customization', ['apparel' => $apparel, 'productionType' => $productionType, 'company' => $company]) }}"
                        class="flex bg-[#9CA3AF] bg-opacity-20 text-opacity-50 rounded-xl text-black gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-gray-600">
                        Back
                    </a>
                    @if(Auth::check())
                    <button type="submit" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                        Add Item to Cart
                    </button>
                    @else
                    <button type="button" onclick="Livewire.dispatch('openModal', { component: 'modal-login-signup' })" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                        Please sign in to continue
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @include('layout.footer')
        @livewire('wire-elements-modal')
    </body>
</form>

</html>