<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col h-screen justify-between bg-gray-50">
    <div class="flex flex-col">
        <div class="flex p-1.5 bg-cPrimary font-gilroy font-bold text-white text-sm justify-center">Production Hub</div>
        <div class="flex">
            @include('layout.printer')
            <div class="flex flex-col gap-y-6 p-8 bg-[#F9F9F9] w-full">
                <!-- Header Section -->
                <div class="flex flex-col gap-y-5">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <h1 class="font-gilroy font-bold text-2xl text-gray-900">Orders</h1>
                        </div>
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Orders
                        </a>
                    </div>

                    @include('partner.printer.order-nav')
                </div>

                <!-- Order Header -->
                <div class="flex items-center justify-between bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <h1 class="font-gilroy font-bold text-xl text-gray-900">
                            Order No. {{$order->order_id}}
                        </h1>
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            {{ $orderStatusText }}
                        </span>
                    </div>
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-cPrimary hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Chat with Customer
                    </button>
                </div>

                <!-- Main Content -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Customer Information Column -->
                    <div class="flex flex-col gap-y-6 col-span-1">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <!-- Customer Information -->
                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cPrimary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Date Requested</h4>
                                        <p class="font-inter text-base text-gray-900">{{ $order->created_at->format('F j, Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cPrimary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Customer Name</h4>
                                        <p class="font-inter text-base text-gray-900">{{$order->user->name}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cPrimary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Email</h4>
                                        <p class="font-inter text-base text-gray-900 break-words">{{$order->user->email}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cPrimary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5h12M6 9h12M6 13h3M6 17h3" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Apparel Type</h4>
                                        <p class="font-inter text-base text-gray-900">{{$order->apparelType->name}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cPrimary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Order Type</h4>
                                        <p class="font-inter text-base text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->is_bulk_order ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $order->is_bulk_order ? 'Bulk' : 'Single' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cPrimary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Customization</h4>
                                        <p class="font-inter text-base text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->is_customized ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $order->is_customized ? 'Personalized' : 'Standard' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($order->designer)
                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cPrimary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Designer</h4>
                                        <p class="font-inter text-base text-gray-900">{{ $order->designer->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Actions Card -->
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
                                <h3 class="font-gilroy font-bold text-white text-base">Actions</h3>
                            </div>
                            <div class="p-4 space-y-3">
                                @if($orderStatusText !== "Completed")
                                <form action="{{ route('partner.printer.cancel-order', ['order_id' => $order->order_id]) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Are you sure you want to cancel this order?')" class="w-full flex justify-center items-center px-4 py-3 bg-red-500 hover:bg-red-600 rounded-lg text-white font-medium transition duration-150 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel Order
                                    </button>
                                </form>
                                @endif

                                @if(isset($nextStageRoute))
                                <form action="{{ route($nextStageRoute, ['order_id' => $order->order_id]) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-cPrimary hover:bg-purple-700 rounded-lg text-white font-medium transition duration-150 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                        {{ $nextStageText ?? 'Move to Next Stage' }}
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Details & Content Column -->
                    <div class="col-span-2 flex flex-col gap-y-6">
                        @if($order->imagesWithStatusOne && !$order->imagesWithStatusOne->isEmpty())
                        <!-- Original Design Specifications Card -->
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
                                <h3 class="font-gilroy font-bold text-white text-base">Original Design Specifications</h3>
                            </div>

                            <div class="p-4 border-b">
                                <h4 class="font-gilroy font-bold text-gray-900 text-base mb-3">Customer Media</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($order->imagesWithStatusOne as $image)
                                    <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="Order Image" class="w-full h-full object-cover">
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="p-4">
                                <h4 class="font-gilroy font-bold text-gray-900 text-base mb-3">Description</h4>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    @if(empty($order->custom_design_info))
                                    <p class="text-gray-500 italic">No description provided</p>
                                    @else
                                    <p class="font-inter text-gray-700 whitespace-pre-line">{{$order->custom_design_info}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($order->imagesWithStatusTwo && !$order->imagesWithStatusTwo->isEmpty())
                        <!-- Designer's Final Design Card -->
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
                                <h3 class="font-gilroy font-bold text-white text-base">Designer's Final Designs</h3>
                            </div>

                            <div class="p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($order->imagesWithStatusTwo as $image)
                                    <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="Designer Image" class="w-full h-auto">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($order->imagesWithStatusFour && !$order->imagesWithStatusFour->isEmpty())
                        <!-- Production-Ready Design Card -->
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
                                <h3 class="font-gilroy font-bold text-white text-base">Production-Ready Designs</h3>
                            </div>

                            <div class="p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($order->imagesWithStatusFour as $image)
                                    <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="Production Image" class="w-full h-auto">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Job Order Information -->
                        @if(isset($order->customizationDetails) && !empty($order->customizationDetails) && $order->customizationDetails->isNotEmpty())
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
                                <h3 class="font-gilroy font-bold text-white text-base">Job Order Details</h3>
                            </div>

                            <div class="p-4">
                                <div class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                    <a href="{{ route('export.customization', $order->order_id) }}" class="flex items-center">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cPrimary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-gilroy font-bold text-gray-900">Download Customization Details</h4>
                                            <p class="text-sm text-gray-600">Excel spreadsheet with all order specifications</p>
                                        </div>
                                    </a>
                                </div>

                                @if(isset($showCustomizationDetails) && $showCustomizationDetails)
                                <div class="mt-4">
                                    <h4 class="font-gilroy font-bold text-gray-900 text-base mb-3">Order Specifications</h4>
                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    @if($order->is_customized)
                                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                    @endif
                                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                                    @if($order->is_customized)
                                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($order->customizationDetails as $detail)
                                                <tr>
                                                    @if($order->is_customized)
                                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->name }}</td>
                                                    @endif
                                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->size->name ?? 'N/A' }}</td>
                                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->quantity }}</td>
                                                    @if($order->is_customized)
                                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $detail->remarks ?? '-' }}</td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
                                <h3 class="font-gilroy font-bold text-white text-base">Job Order Details</h3>
                            </div>
                            <div class="p-6 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <h4 class="font-gilroy font-bold text-lg text-gray-900 mb-2">Confirmation Form Not Filled Up</h4>
                                <p class="text-gray-600 mb-4">The customer has not yet completed their order customization form.</p>
                            </div>
                        </div>
                        @endif

                        <!-- Stage-Specific Content -->
                        @hasSection('pageSpecificContent')
                        @yield('pageSpecificContent')
                        @else
                        {!! $pageSpecificContent ?? '' !!}
                        @endif
                        
                        @hasSection('additional-actions')
                        @yield('additional-actions')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>