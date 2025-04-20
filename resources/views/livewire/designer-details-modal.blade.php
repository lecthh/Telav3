<div>
    @if($selectedItem && $showModal)
    <x-view-details-modal wire:model="showModal" title="Designer Details">
        <div class="bg-white rounded-lg shadow-sm">
            <!-- Designer Header with Avatar and Key Info -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-t-lg border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center gap-6">
                    <div class="flex-shrink-0 flex justify-center">
                        <img src="{{ $selectedItem->user && $selectedItem->user->avatar ? asset('storage/' . $selectedItem->user->avatar) : asset('images/default.png') }}"
                            alt="{{ $selectedItem->user_name }}"
                            class="w-24 h-24 rounded-full object-cover border-4 border-white shadow">
                    </div>
                    <div class="flex-1 min-w-0 text-center md:text-left">
                        <h2 class="text-xl font-bold text-gray-900">{{ $selectedItem->user_name }}</h2>
                        <p class="text-sm text-gray-500">Designer ID: {{ $selectedItem->designer_id }}</p>
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $selectedItem->is_freelancer ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $selectedItem->is_freelancer ? 'Freelancer' : $selectedItem->productionCompany->company_name . ' Designer' }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $selectedItem->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $selectedItem->is_available ? 'Available' : 'Not Available' }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $selectedItem->is_verified ? 'Verified' : 'Not Verified' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex flex-wrap space-x-6 px-6" aria-label="Designer Profile Tabs">
                    <button type="button"
                        wire:click="$set('activeTab', 'general')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ (!isset($activeTab) || $activeTab === 'general') ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ (!isset($activeTab) || $activeTab === 'general') ? 'page' : 'false' }}">
                        General Details
                    </button>
                    @if($selectedItem->orders && $selectedItem->orders->count() && $type === 'manage')
                    <button type="button"
                        wire:click="$set('activeTab', 'orders')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'orders' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'orders' ? 'page' : 'false' }}">
                        Orders
                    </button>
                    @endif
                    @if($selectedItem->reviews && $selectedItem->reviews->where('is_visible', true)->count())
                    <button type="button"
                        wire:click="$set('activeTab', 'reviews')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'reviews' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'reviews' ? 'page' : 'false' }}">
                        Reviews
                    </button>
                    @endif
                    @if($selectedItem->pricing && $selectedItem->pricing->count())
                    <button type="button"
                        wire:click="$set('activeTab', 'pricing')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'pricing' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'pricing' ? 'page' : 'false' }}">
                        Pricing
                    </button>
                    @endif
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                @if(!isset($activeTab) || $activeTab === 'general')
                <!-- General Designer Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column: Basic Information -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Basic Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Designer ID</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->designer_id }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Designer Name</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->user_name }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Freelancer</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->is_freelancer ? 'Yes' : 'No' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Availability</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->is_available ? 'Available' : 'Not Available' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Ratings &amp; Reviews</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Average Rating</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->average_rating }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Review Count</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->review_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Professional Details -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Professional Details</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Production Company</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->production_company_name }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Talent Fee</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->talent_fee }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Max Free Revisions</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->max_free_revisions }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Additional Revision Fee</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->addtl_revision_fee }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Description</h3>
                            <p class="text-sm text-gray-900">{{ $selectedItem->designer_description }}</p>
                        </div>

                    </div>
                </div>

                @elseif($activeTab === 'orders' && $type === 'manage')
                <!-- Orders Associated with This Designer -->
                <div>
                    @if($selectedItem->orders && $selectedItem->orders->count())
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-sm font-semibold text-gray-700">Designer Orders</h3>
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
                        <p class="mt-1 text-sm text-gray-500">This designer hasn't received any orders yet.</p>
                    </div>
                    @endif
                </div>

                @elseif($activeTab === 'reviews')
                <!-- Designer Reviews -->
                <div>
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-sm font-semibold text-gray-700">Customer Reviews</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $selectedItem->reviews->where('is_visible', true)->count() }} Reviews
                        </span>
                    </div>
                    @if($selectedItem->reviews && $selectedItem->reviews->where('is_visible', true)->count())
                    <div class="space-y-4">
                        @foreach($selectedItem->reviews->where('is_visible', true)->take(5) as $review)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.519 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.519-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No reviews yet</h3>
                        <p class="mt-1 text-sm text-gray-500">This designer hasn't received any reviews yet.</p>
                    </div>
                    @endif
                </div>

                @elseif($activeTab === 'pricing')
                <!-- Pricing Tab for Designer -->
                <div>
                    @if($selectedItem->pricing && $selectedItem->pricing->count())
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Designer Pricing</h3>
                    </div>
                    <div class="overflow-x-auto max-h-64 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Service
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Base Fee
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Additional Fee
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($selectedItem->pricing as $price)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $price->service ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($price->base_fee, 2) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($price->additional_fee, 2) }}
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
                        <p class="mt-1 text-sm text-gray-500">This designer hasn't set up their pricing details yet.</p>
                    </div>
                    @endif
                </div>

                @endif

            </div>
            <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                @if($selectedItem->isBlocked())
                <button type="button"
                    wire:click="showApproveModal"
                    class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 sm:ml-3 sm:w-auto">
                    <span wire:loading wire:target="showApproveModal" class="mr-2">
                        <x-spinner wire:loading />
                    </span>
                    <span wire:loading.remove wire:target="showApproveModal">Reactivate Designer</span>
                </button>
                @else
                <button type="button"
                    wire:click="showBlockModal"
                    class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">
                    <span wire:loading wire:target="showBlockModal" class="mr-2">
                        <x-spinner wire:loading />
                    </span>
                    <span wire:loading.remove wire:target="showBlockModal">Block Designer</span>
                </button>
                @endif
            </div>
        </div>
    </x-view-details-modal>
    @endif
</div>