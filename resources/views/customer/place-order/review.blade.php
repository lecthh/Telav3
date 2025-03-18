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

    <body class="flex flex-col h-screen justify-between bg-white">
        <div class="font-inter flex flex-col px-[200px] py-[80px] gap-y-[40px]">
            <!-- Header Section -->
            <div class="flex flex-col gap-y-8">
                @include('customer.place-order.steps')
                <div class="flex flex-col gap-y-3 animate-fade-in">
                    <h1 class="font-gilroy font-bold text-5xl text-gray-900">Order Review</h1>
                    <p class="font-inter text-lg text-gray-600 max-w-3xl">Take a moment to review your custom apparel order details before proceeding to checkout.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate-fade-in">
                <!-- Left Column: Order Details -->
                <div class="col-span-2 flex flex-col gap-y-8">
                    <!-- Production Company Card -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 shadow-sm">
                        <h3 class="font-gilroy font-bold text-xl mb-4 text-gray-900">Production Partner</h3>
                        <div class="flex items-start gap-x-5">
                            <div class="w-[120px] h-[120px] rounded-lg bg-white shadow-sm flex items-center justify-center overflow-hidden border border-gray-200">
                                @if($productionCompany->company_logo && Str::startsWith($productionCompany->company_logo, 'company_logos/'))
                                <img src="{{ Storage::url($productionCompany->company_logo) }}" alt="{{ $productionCompany->company_name }}" class="object-contain w-full h-full p-2">
                                @elseif($productionCompany->company_logo)
                                <img src="{{ asset($productionCompany->company_logo) }}" alt="{{ $productionCompany->company_name }}" class="object-contain w-full h-full p-2">
                                @else
                                <img src="{{ asset('imgs/companyLogo/placeholder.jpg') }}" alt="{{ $productionCompany->company_name }}" class="object-contain w-full h-full p-2">
                                @endif
                            </div>
                            <div class="flex flex-col gap-y-2">
                                <h4 class="font-gilroy font-bold text-xl text-gray-900">{{ $productionCompany->company_name }}</h4>
                                <div class="flex items-baseline gap-x-2">
                                    <span class="font-gilroy font-bold text-2xl text-cPrimary">{{ number_format($orderPrice, 2) }} PHP</span>
                                    <span class="text-sm text-gray-600">per item</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $customization['order_type'] === 'bulk' ? 'Bulk order' : 'Individual order' }} price</p>
                                <div class="mt-2">
                                    <a href="#" class="inline-flex items-center text-cPrimary hover:text-purple-700 text-sm font-medium">
                                        <span>View samples</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Specifications -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 shadow-sm">
                        <h3 class="font-gilroy font-bold text-xl mb-4 text-gray-900">Order Specifications</h3>
                        <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                            <div class="flex flex-col gap-y-1">
                                <p class="text-gray-600">Apparel Type</p>
                                <p class="font-medium text-gray-900">{{ $apparelName }}</p>
                            </div>
                            <div class="flex flex-col gap-y-1">
                                <p class="text-gray-600">Production Method</p>
                                <p class="font-medium text-gray-900">{{ $productionTypeName }}</p>
                            </div>
                            <div class="flex flex-col gap-y-1">
                                <p class="text-gray-600">Order Type</p>
                                <p class="font-medium text-gray-900">{{ ucfirst($customization['order_type']) }}</p>
                            </div>
                            <div class="flex flex-col gap-y-1">
                                <p class="text-gray-600">Customization</p>
                                <p class="font-medium text-gray-900">{{ ucfirst($customization['custom_type']) }}</p>
                            </div>
                            <div class="flex flex-col gap-y-1">
                                <p class="text-gray-600">Quantity</p>
                                <p class="font-medium text-gray-900">{{ $quantity }} {{ $quantity > 1 ? 'items' : 'item' }}</p>
                            </div>
                            <div class="flex flex-col gap-y-1">
                                <p class="text-gray-600">Unit Price</p>
                                <p class="font-medium text-gray-900">{{ number_format($orderPrice, 2) }} PHP</p>
                            </div>
                        </div>
                    </div>

                    <!-- Design Section -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 shadow-sm">
                        <h3 class="font-gilroy font-bold text-xl mb-4 text-gray-900">Design Preview</h3>

                        @if($canvasImage)
                        <div class="bg-white rounded-lg overflow-hidden border border-gray-200 shadow-sm mb-6">
                            <img src="{{ $canvasImage }}" alt="Design Canvas" class="w-full max-h-[300px] object-contain">
                        </div>
                        @endif

                        @if(!empty($customization['media']))
                        <div>
                            <h4 class="font-medium text-gray-700 mb-3">Reference Images</h4>
                            <div class="grid grid-cols-4 gap-4">
                                @foreach ($customization['media'] as $media)
                                <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 bg-white shadow-sm">
                                    <img src="{{ asset('storage/' . $media) }}" alt="Design Reference" class="w-full h-full object-cover">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Design Instructions -->
                    @if(!empty($customization['description']))
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 shadow-sm">
                        <h3 class="font-gilroy font-bold text-xl mb-4 text-gray-900">Design Instructions</h3>
                        <div class="prose max-w-none text-gray-700">
                            {{ $customization['description'] }}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column: Order Summary & Actions -->
                <div class="col-span-1">
                    <div class="sticky top-6">
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 shadow-sm mb-6">
                            <h3 class="font-gilroy font-bold text-xl mb-4 text-gray-900">Order Summary</h3>

                            <div class="flex flex-col gap-y-3">
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600">Unit Price</span>
                                    <span class="font-medium">{{ number_format($orderPrice, 2) }} PHP</span>
                                </div>

                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600">Quantity</span>
                                    <span class="font-medium">× {{ $quantity }}</span>
                                </div>

                                @if($customization['order_type'] === 'bulk' && $basePrice > $bulkPrice)
                                <div class="flex justify-between items-center py-2 text-cPrimary">
                                    <span>Bulk Discount</span>
                                    <span>-{{ number_format(($basePrice - $bulkPrice) * $quantity, 2) }} PHP</span>
                                </div>
                                @endif

                                <div class="border-t border-gray-200 my-2"></div>

                                <div class="flex justify-between items-center py-2">
                                    <span class="font-bold text-gray-900">Order Total</span>
                                    <span class="font-bold text-xl text-gray-900">{{ number_format($totalPrice, 2) }} PHP</span>
                                </div>

                                <div class="flex justify-between items-center py-2 bg-purple-50 rounded-lg p-2">
                                    <span class="text-gray-700">Downpayment (50%)</span>
                                    <span class="font-medium text-cPrimary">{{ number_format($totalPrice / 2, 2) }} PHP</span>
                                </div>

                                @if($customization['order_type'] === 'bulk')
                                <p class="text-sm text-gray-500 mt-2">*Minimum bulk order quantity is 10 items</p>
                                @endif

                                <p class="text-sm text-gray-500">*Final price may be adjusted based on design customization details</p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4">
                            <a href="{{ route('customer.place-order.customization', ['apparel' => $apparel, 'productionType' => $productionType, 'company' => $company]) }}"
                                class="flex justify-center items-center py-3 px-6 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition duration-150 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Back to Customization
                            </a>

                            @if(Auth::check())
                            <button type="submit"
                                class="flex justify-center items-center py-3 px-6 bg-cPrimary hover:bg-purple-700 rounded-xl text-white font-medium transition duration-150 ease-in-out">
                                Add to Cart
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </button>
                            @else
                            <button type="button"
                                onclick="Livewire.dispatch('openModal', { component: 'modal-login-signup' })"
                                class="flex justify-center items-center py-3 px-6 bg-cPrimary hover:bg-purple-700 rounded-xl text-white font-medium transition duration-150 ease-in-out">
                                Sign in to Continue
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layout.footer')
        @livewire('wire-elements-modal')
    </body>
</form>

</html>