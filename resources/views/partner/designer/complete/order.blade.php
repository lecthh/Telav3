<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col min-h-screen bg-gray-50">
    <div class="flex flex-col flex-grow">
        <x-blocked-banner-wrapper :entity="$designer" />
        <!-- Header Bar -->
        <div class="flex p-2 bg-cGreen font-gilroy font-bold text-black text-sm justify-center items-center shadow-sm">
            Designer Hub
        </div>

        <div class="flex flex-grow">
            <!-- Sidebar -->
            @include('layout.designer')

            <!-- Main Content -->
            <div class="flex flex-col gap-y-6 p-6 md:p-10 bg-gray-50 w-full overflow-auto">
                <!-- Header with Breadcrumbs -->
                <div class="flex flex-col gap-y-3">
                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        <a href="{{ route('partner.designer.complete') }}" class="hover:text-cGreen transition-colors">Completed Orders</a>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="font-medium">Order #{{ substr($order->order_id, -6) }}</span>
                    </div>

                    <h1 class="font-gilroy font-bold text-2xl text-gray-900">Completed Order</h1>

                    <!-- Status Badge -->
                    <div class="inline-flex items-center mb-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            {{ $order->status->name }}
                        </span>
                        <span class="ml-2 text-sm text-gray-600">Completed on {{ $order->updated_at->format('F j, Y') }}</span>
                    </div>
                </div>

                <!-- Order Content -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Left Column - Order Info -->
                    <div class="md:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h2 class="font-gilroy font-bold text-lg text-gray-900">Order Information</h2>
                            </div>

                            <!-- Order Info List -->
                            <div class="divide-y divide-gray-100">
                                <div class="px-6 py-4 flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                                        @include('svgs.calendar')
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Date Requested</h3>
                                        <p class="mt-1 text-sm text-gray-600">{{ $order->created_at->format('F j, Y') }}</p>
                                    </div>
                                </div>

                                <div class="px-6 py-4 flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                                        @include('svgs.user-single')
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Customer</h3>
                                        <p class="mt-1 text-sm text-gray-600">{{ $order->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                                    </div>
                                </div>

                                <div class="px-6 py-4 flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                                        @include('svgs.shirt')
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Apparel Type</h3>
                                        <p class="mt-1 text-sm text-gray-600">{{ $order->apparelType->name }}</p>
                                    </div>
                                </div>

                                <div class="px-6 py-4 flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                                        @include('svgs.receipt-check')
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Order Specifications</h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $order->is_bulk_order ? 'Bulk' : 'Single' }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 ml-1">
                                                {{ $order->is_customized ? 'Personalized' : 'Standard' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="px-6 py-4 flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                                        @include('svgs.paintbrush')
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Design Status</h3>
                                        <p class="mt-1 text-sm text-gray-600">Design completed</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-green-50">
                                <h2 class="font-gilroy font-bold text-lg text-gray-900">Final Design</h2>
                            </div>

                            <div class="p-6">
                                <div class="mb-6">
                                    <h3 class="font-medium text-gray-900 mb-3">Approved Design</h3>
                                    @if($order->imagesWithStatusFour->count() > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($order->imagesWithStatusFour as $image)
                                        <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-all">
                                            <img src="{{ asset('storage/' . $image->image) }}" alt="Final Design" class="w-full h-full object-cover">
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <p class="text-gray-500 text-sm">No final design images available.</p>
                                    @endif
                                </div>

                                @if($order->imagesWithStatusOne->count() > 0)
                                <div class="mb-6 pt-6 border-t border-gray-100">
                                    <h3 class="font-medium text-gray-900 mb-3">Customer Supplied Images</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach($order->imagesWithStatusOne as $image)
                                        <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 opacity-80 hover:opacity-100 transition-opacity">
                                            <img src="{{ asset('storage/' . $image->image) }}" alt="Customer Image" class="w-full h-full object-cover">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Description -->
                                <div class="pt-6 border-t border-gray-100">
                                    <h3 class="font-medium text-gray-900 mb-3">Design Specifications</h3>
                                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        @if($order->custom_design_info)
                                        <p class="text-gray-700 whitespace-pre-line">{{ $order->custom_design_info }}</p>
                                        @else
                                        <p class="text-gray-500 text-sm">No specific instructions provided.</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex justify-between mt-6 pt-6 border-t border-gray-100">
                                    <a href="{{ route('partner.designer.complete') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cGreen">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                        </svg>
                                        Back to Completed Orders
                                    </a>

                                    <button type="button" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-cGreen hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cGreen">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        Message Client
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>