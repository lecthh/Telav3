<div>
    @if($selectedReport && $showModal)
    <x-view-details-modal wire:model="showModal" title="Report Details">
        <div class="bg-white rounded-lg shadow-sm">
            <!-- Report Header with Key Info -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 p-6 rounded-t-lg border-b border-gray-200">
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 flex items-center justify-center rounded-full bg-red-100 border-4 border-white shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl font-bold text-gray-900 truncate">Report #{{ $selectedReport->id }}</h2>
                        <p class="text-sm text-gray-500 truncate">{{ $selectedReport->reason }}</p>
                        <div class="flex items-center mt-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                        $selectedReport->status === 'resolved' ? 'bg-green-100 text-green-800' : 
                        ($selectedReport->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') 
                    }}">
                                {{ ucfirst($selectedReport->status) }}
                            </span>
                            @if($selectedReport->order_id)
                            <span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Order Related
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-6 px-6" aria-label="Report Tabs">
                    <button type="button"
                        wire:click="$set('activeTab', 'details')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'details' ? 'border-red-600 text-red-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'details' ? 'page' : 'false' }}">
                        Report Details
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'order')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'order' ? 'border-red-600 text-red-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'order' ? 'page' : 'false' }}">
                        Order Information
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'entities')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'entities' ? 'border-red-600 text-red-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'entities' ? 'page' : 'false' }}">
                        Related Entities
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'images')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'images' ? 'border-red-600 text-red-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'images' ? 'page' : 'false' }}">
                        Report Images
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                @if(!isset($activeTab) || $activeTab === 'details')
                <!-- Report Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Report Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Report ID</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedReport->id }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Reason</span>
                                    <span class="block text-sm font-medium text-gray-900">{!! $selectedReport->reason !!}</span>
                                </div>

                                <div>
                                    <span class="block text-xs text-gray-500">Status</span>
                                    <span class="block text-sm font-medium {{ 
                                $selectedReport->status === 'resolved' ? 'text-green-600' : 
                                ($selectedReport->status === 'pending' ? 'text-yellow-600' : 'text-red-600') 
                            }}">
                                        {{ ucfirst($selectedReport->status) }}
                                    </span>
                                </div>
                                @if($selectedReport->order_id)
                                <div>
                                    <span class="block text-xs text-gray-500">Order ID</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedReport->order_id }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Timeline</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Created At</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedReport->created_at->format('M d, Y H:i') }}
                                        <span class="text-xs text-gray-500">({{ $selectedReport->created_at->diffForHumans() }})</span>
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Last Updated</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedReport->updated_at->format('M d, Y H:i') }}
                                        <span class="text-xs text-gray-500">({{ $selectedReport->updated_at->diffForHumans() }})</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Full Width Description -->
                    <div class="col-span-1 md:col-span-2">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Description</h3>
                            <div class="mt-1 prose max-w-none">
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $selectedReport->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($activeTab === 'order')
                <!-- Order Information -->
                <div>
                    @if($selectedReport->order)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-sm font-semibold text-gray-700">Order Details</h3>
                            <button
                                type="button"
                                wire:click="viewOrder('{{ $selectedReport->order_id }}')"
                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View Full Order
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="block text-xs text-gray-500">Order ID</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedReport->order->order_id }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Order Status</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                $selectedReport->order->status && $selectedReport->order->status->status_id >= 1 && $selectedReport->order->status->status_id != 8 
                                    ? 'bg-green-100 text-green-800' 
                                    : 'bg-red-100 text-red-800' 
                                }}">
                                        {{ $selectedReport->order->status->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="block text-xs text-gray-500">Final Price</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        ${{ number_format($selectedReport->order->final_price, 2) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Order Date</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedReport->order->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No order information</h3>
                        <p class="mt-1 text-sm text-gray-500">This report is not associated with any order.</p>
                    </div>
                    @endif
                </div>
                @elseif($activeTab === 'entities')
                <!-- Related Entities -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Reporter Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Reporter Information</h3>

                        @if($selectedReport->reporter)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                @if(method_exists($selectedReport->reporter, 'getAvatarAttribute') && $selectedReport->reporter->avatar)
                                <img src="{{ asset($selectedReport->reporter->avatar) }}"
                                    alt="{{ $selectedReport->reporter->name ?? 'Reporter' }}"
                                    class="h-10 w-10 rounded-full">
                                @else
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">
                                    {{ $selectedReport->reporter->name ?? 'Unknown' }}
                                </h4>
                                <p class="text-xs text-gray-500">{{ class_basename($selectedReport->reporter_type) }}</p>
                                <button
                                    type="button"
                                    wire:click="viewEntity('reporter', '{{ $selectedReport->reporter_id }}', '{{ $selectedReport->reporter_type }}')"
                                    class="mt-1 inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    View Details
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="text-sm text-gray-500">Reporter information unavailable</div>
                        @endif
                    </div>

                    <!-- Reported Entity Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Reported Entity</h3>

                        @if($selectedReport->reported)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                @if(method_exists($selectedReport->reported, 'getAvatarAttribute') && $selectedReport->reported->avatar)
                                <img src="{{ asset($selectedReport->reported->avatar) }}"
                                    alt="{{ $selectedReport->reported->name ?? 'Reported' }}"
                                    class="h-10 w-10 rounded-full">
                                @else
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">
                                    {{ $selectedReport->reported->name ?? $selectedReport->reported->title ?? 'Unknown' }}
                                </h4>
                                <p class="text-xs text-gray-500">{{ class_basename($selectedReport->reported_type) }}</p>
                                <button
                                    type="button"
                                    wire:click="viewEntity('reported', '{{ $selectedReport->reported_id }}', '{{ $selectedReport->reported_type }}')"
                                    class="mt-1 inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    View Details
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="text-sm text-gray-500">Reported entity information unavailable</div>
                        @endif
                    </div>
                </div>
                @elseif($activeTab === 'images')
                <!-- Report Images (Updated) -->
                <div class="space-y-6">
                    @if($selectedReport->images && $selectedReport->images->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($selectedReport->images as $image)
                        <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm group relative">
                            <img src="{{ Storage::url($image->path) }}"
                                alt="Report image {{ $loop->iteration }}"
                                class="w-full h-48 object-cover">
                            <div class="p-2 bg-white">
                                <p class="text-xs text-gray-500 truncate">{{ $image->original_name ?? 'Image ' . $loop->iteration }}</p>
                                <p class="text-xs text-gray-400">{{ $image->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <button
                                    type="button"
                                    wire:click="viewImage('{{ $image->id }}')"
                                    class="mx-1 inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View
                                </button>
                                <a
                                    href="{{ Storage::url($image->path) }}"
                                    download="{{ $image->original_name ?? 'report-image-'.$image->id }}"
                                    class="mx-1 inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12 bg-gray-50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No images found</h3>
                        <p class="mt-1 text-sm text-gray-500">This report doesn't have any attached images.</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Footer with Actions -->
            <div class="bg-gray-50 px-6 py-3 rounded-b-lg border-t border-gray-200 flex justify-between">
                <div>
                    @if($selectedReport->status !== 'resolved')
                    <button
                        type="button"
                        wire:click="updateStatus('{{ $selectedReport->id }}', 'resolved')"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Mark as Resolved
                    </button>
                    @endif

                    @if($selectedReport->status !== 'investigating')
                    <button
                        type="button"
                        wire:click="updateStatus('{{ $selectedReport->id }}', 'investigating')"
                        class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        Mark as Investigating
                    </button>
                    @endif
                </div>

                <button
                    type="button"
                    wire:click="$set('showModal', false)"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Close
                </button>
            </div>
        </div>
    </x-view-details-modal>
    @endif

    @if($showImageModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-4xl w-full relative">
            <button
                class="absolute top-2 right-2 text-gray-600 hover:text-gray-900"
                wire:click="$set('showImageModal', false)">
                &times;
            </button>
            @php
            $image = $selectedReport->images->firstWhere('id', $selectedImageId);
            @endphp

            @if($image)
            <img src="{{ Storage::url($image->path) }}" alt="{{ $image->original_name ?? 'Report Image' }}"
                class="w-full max-h-[75vh] object-contain mx-auto rounded-md">
            <p class="mt-2 text-sm text-gray-600 text-center">
                {{ $image->original_name ?? 'Image' }} • {{ $image->created_at->format('F d, Y') }}
            </p>
            @else
            <p class="text-center text-red-500">Image not found.</p>
            @endif
        </div>
    </div>
    @endif

</div>