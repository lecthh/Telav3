<div>
    @if($selectedItem && $showModal)
    <x-view-details-modal wire:model="showModal" title="Production Company Profile">
        <div class="bg-white rounded-lg shadow-sm">
            <!-- Company Header with Logo and Key Info -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-t-lg border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center gap-6">
                    <div class="flex-shrink-0 flex justify-center">
                        <img src="{{ $selectedItem->company_logo ? asset($selectedItem->company_logo) : asset('images/default.png') }}"
                            alt="{{ $selectedItem->company_name }}"
                            class="w-24 h-24 rounded-full object-cover border-4 border-white shadow">
                    </div>
                    <div class="flex-1 min-w-0 text-center md:text-left">
                        <h2 class="text-xl font-bold text-gray-900">{{ $selectedItem->company_name }}</h2>
                        <p class="text-sm text-gray-500">{{ $selectedItem->email }}</p>
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $selectedItem->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($selectedItem->status) }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $selectedItem->is_verified ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $selectedItem->is_verified ? 'Verified Company' : 'Verification Pending' }}
                            </span>
                            @if($modalType === 'manage')
                            <div class="flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                {{ $selectedItem->avg_rating }} ({{ $selectedItem->review_count }} reviews)
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex flex-wrap space-x-6 px-6" aria-label="Company Profile Tabs">
                    <button type="button"
                        wire:click="$set('activeTab', 'general')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'general' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'general' ? 'page' : 'false' }}">
                        Company Details
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'documents')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'documents' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'documents' ? 'page' : 'false' }}">
                        Documents
                    </button>
                    @if($modalType === 'manage')
                    <button type="button"
                        wire:click="$set('activeTab', 'orders')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'orders' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'orders' ? 'page' : 'false' }}">
                        Orders
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'pricing')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'pricing' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'pricing' ? 'page' : 'false' }}">
                        Pricing
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'reviews')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'reviews' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'reviews' ? 'page' : 'false' }}">
                        Reviews
                    </button>
                    @endif
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                @if(!isset($activeTab) || $activeTab === 'general')
                <!-- General Company Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Company Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Company Name</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->company_name }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Email Address</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->email }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Phone Number</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->phone }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Address</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->address }}</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Production Capabilities</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Production Types</span>
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach($selectedItem->getProductionTypeNames() as $type)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $type }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Apparel Types</span>
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach($selectedItem->getApparelTypeNames() as $type)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $type }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($modalType === 'manage')
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Rating Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Average Rating</span>
                                    <div class="flex items-center mt-1">
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= round($selectedItem->avg_rating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                                @endfor
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-900">{{ $selectedItem->avg_rating }} out of 5</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Total Reviews</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->review_count }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                @elseif($activeTab === 'orders')
                <!-- Orders Associated with This Company -->
                <div>
                    @if(isset($selectedItem->orders) && $selectedItem->orders->count())
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-sm font-semibold text-gray-700">Production Orders</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $selectedItem->orders->count() }} Orders
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order ID
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Client
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($selectedItem->orders as $order)
                                <tr class="hover:bg-gray-50 cursor-pointer" wire:click="onRowClick('{{ $order->order_id }}')">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $order->order_id }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->user ? $order->user->name : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                            $order->status_id >= 1 && $order->status_id != 8 
                                                ? 'bg-green-100 text-green-800' 
                                                : 'bg-red-100 text-red-800' 
                                            }}">
                                            {{ $order->status->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($order->final_price, 2) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No orders found</h3>
                        <p class="mt-1 text-sm text-gray-500">This company hasn't received any orders yet.</p>
                    </div>
                    @endif
                </div>

                @elseif($activeTab === 'pricing')
                <!-- Company Pricing -->
                <div>
                    @if($selectedItem->pricing && $selectedItem->pricing->count())
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Production Pricing</h3>
                    </div>
                    <div class="overflow-x-auto max-h-64 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Apparel Type
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Production Method
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Base Price
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bulk Price
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($selectedItem->pricing as $price)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $price->apparelType ? $price->apparelType->name : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $price->productionType ? $price->productionType->name : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($price->base_price, 2) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($price->bulk_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No pricing information</h3>
                        <p class="mt-1 text-sm text-gray-500">This company hasn't set up their pricing details yet.</p>
                    </div>
                    @endif
                </div>

                @elseif($activeTab === 'reviews')
                <!-- Company Reviews -->
                <div>
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-sm font-semibold text-gray-700">Customer Reviews</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $selectedItem->review_count }} Reviews
                        </span>
                    </div>

                    @if($selectedItem->reviews && $selectedItem->reviews->count())
                    <div class="space-y-4">
                        @foreach($selectedItem->reviews->where('is_visible', true)->take(5) as $review)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-900">{{ $review->rating }}/5</span>
                                </div>
                                <span class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-gray-900">{{ $review->title }}</p>
                                <p class="mt-1 text-sm text-gray-600">{{ $review->content }}</p>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                By {{ $review->user ? $review->user->name : 'Anonymous' }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($selectedItem->reviews->where('is_visible', true)->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            View all {{ $selectedItem->reviews->where('is_visible', true)->count() }} reviews
                        </a>
                    </div>
                    @endif
                    @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No reviews yet</h3>
                        <p class="mt-1 text-sm text-gray-500">This company hasn't received any reviews yet.</p>
                    </div>
                    @endif
                </div>

                @elseif($activeTab === 'documents')
                <!-- Business Documents -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Business Documentation</h3>

                    @if($selectedItem->businessDocuments && $selectedItem->businessDocuments->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($selectedItem->businessDocuments as $document)
                        <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 p-2 bg-blue-100 rounded-md">
                                <svg class="h-6 w-6 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-sm font-medium text-gray-900">{{ $document->name }}</h4>
                                <p class="mt-1 text-xs text-gray-500">Uploaded on {{ $document->created_at->format('M d, Y') }}</p>
                                <a href="{{ asset('storage/' . $document->path) }}" download
                                    class="mt-2 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Download
                                    <svg class="ml-1 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No documents available</h3>
                        <p class="mt-1 text-sm text-gray-500">This company hasn't uploaded any business documents yet.</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                @if($modalType === 'approve')
                <button type="button"
                    wire:click="showApproveModal"
                    class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 sm:ml-3 sm:w-auto">
                    <span wire:loading wire:target="showApproveModal" class="mr-2">
                        <x-spinner wire:loading />
                    </span>
                    <span wire:loading.remove wire:target="showApproveModal">Approve Production Company</span>
                </button>
                <button type="button"
                    wire:click="showBlockModal"
                    class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">
                    <span wire:loading wire:target="showBlockModal" class="mr-2">
                        <x-spinner wire:loading />
                    </span>
                    <span wire:loading.remove wire:target="showBlockModal">Deny Production Company</span>
                </button>
                @elseif($selectedItem->isBlocked() && $modalType === 'manage')
                <button type="button"
                    wire:click="showApproveModal"
                    class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 sm:ml-3 sm:w-auto">
                    <span wire:loading wire:target="showApproveModal" class="mr-2">
                        <x-spinner wire:loading />
                    </span>
                    <span wire:loading.remove wire:target="showApproveModal">Reactivate Production Company</span>
                </button>
                @else
                <button type="button"
                    wire:click="showBlockModal"
                    class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">
                    <span wire:loading wire:target="showBlockModal" class="mr-2">
                        <x-spinner wire:loading />
                    </span>
                    <span wire:loading.remove wire:target="showBlockModal">Block Production Company</span>
                </button>
                @endif
            </div>
        </div>
    </x-view-details-modal>
    @endif
</div>