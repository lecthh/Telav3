<div>
    @if($selectedItem && $showModal)
    <x-view-details-modal wire:model="showModal" title="Order Details">
        <div class="bg-white rounded-lg shadow-sm">
            <!-- Order Header with Key Info -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-t-lg border-b border-gray-200">
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center border-4 border-white shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl font-bold text-gray-900 truncate">Order #{{ $selectedItem->order_id }}</h2>
                        <p class="text-sm text-gray-500 truncate">{{ $selectedItem->user->name ?? 'N/A' }}</p>
                        <div class="flex items-center mt-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                            $selectedItem->status->status_id >= 1 && $selectedItem->status->status_id != 8 
                                ? 'bg-green-100 text-green-800' 
                                : 'bg-red-100 text-red-800' 
                            }}">
                                {{ $selectedItem->status->name ?? 'N/A' }}
                            </span>
                            <span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $selectedItem->productionType->name ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-6 px-6" aria-label="Order Details Tabs">
                    <button type="button"
                        wire:click="$set('activeTab', 'general')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'general' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'general' ? 'page' : 'false' }}">
                        General Information
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'details')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'details' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'details' ? 'page' : 'false' }}">
                        Order Specifications
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'history')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'history' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'history' ? 'page' : 'false' }}">
                        Activity History
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'payment_history')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'payment_history' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'payment_history' ? 'page' : 'false' }}">
                        Payment History
                    </button>

                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                @if(!isset($activeTab) || $activeTab === 'general')
                <!-- General Order Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Customer Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Client Name</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->user->name ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Email Address</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->user->email ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Production Company</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->productionCompany->company_name ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Phone Number</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->user->addressInformation->phone_number ?? 'Not provided' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Order Status</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Status</span>
                                    <span class="block text-sm font-medium {{ 
                                    $selectedItem->status->status_id >= 1 && $selectedItem->status->status_id != 8 
                                        ? 'text-green-600' 
                                        : 'text-red-600' 
                                    }}">
                                        {{ $selectedItem->status->name ?? 'N/A' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Assigned Designer</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedItem->designer ? $selectedItem->getDesignerNameAttribute() : 'Not Assigned' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Order Date</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedItem->created_at->format('M d, Y') }}
                                        <span class="text-xs text-gray-500">({{ $selectedItem->created_at->diffForHumans() }})</span>
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Last Updated</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedItem->updated_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($activeTab === 'details')
                <!-- Order Specifications -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Order Specifications</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Order ID</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->order_id }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Apparel Type</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->apparelType->name ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Production Type</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->productionType->name ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Quantity</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->quantity }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Payment Details</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Downpayment</span>
                                    <span class="block text-sm font-medium text-gray-900">${{ number_format($selectedItem->downpayment_amount, 2) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Final Price</span>
                                    <span class="block text-sm font-medium text-gray-900">${{ number_format($selectedItem->final_price, 2) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Balance</span>
                                    <span class="block text-sm font-medium text-gray-900">${{ number_format($selectedItem->final_price - $selectedItem->downpayment_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Delivery Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Estimated Delivery Date</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedItem->eta ? \Carbon\Carbon::parse($selectedItem->eta)->format('M d, Y') : 'Not set' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Days Remaining</span>
                                    @if($selectedItem->eta)
                                    <span class="block text-sm font-medium {{ \Carbon\Carbon::parse($selectedItem->eta)->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ \Carbon\Carbon::parse($selectedItem->eta)->isPast()
                    ? 'Overdue by ' . \Carbon\Carbon::parse($selectedItem->eta)->diffInDays() . ' days'
                    : \Carbon\Carbon::parse($selectedItem->eta)->diffInDays() . ' days' }}
                                    </span>
                                    @else
                                    <span class="block text-sm font-medium text-gray-500">Not set</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($activeTab === 'history')
                <!-- Order Activity History -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Activity Timeline</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $selectedItem->notifications->count() }} Activities
                        </span>
                    </div>

                    @if($selectedItem->notifications->count())
                    <div class="space-y-1">
                        @foreach($selectedItem->notifications->sortByDesc('created_at') as $notification)
                        <div class="relative pb-6">
                            @if(!$loop->last)
                            <div class="absolute top-5 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></div>
                            @endif
                            <div class="relative flex items-start space-x-3">
                                <div class="relative">
                                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center ring-8 ring-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
                                        <p class="text-sm text-gray-700">{{ $notification->message }}</p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->format('M d, Y h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No activity history</h3>
                        <p class="mt-1 text-sm text-gray-500">No updates are available for this order yet.</p>
                    </div>
                    @endif
                </div>

                @elseif($activeTab === 'payment_history')
                <!-- Payment History -->
                <div class="space-y-6">
                    <!-- Balance Receipts -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Balance Payments</h3>
                        @if($selectedItem->balanceReceipts->isNotEmpty())
                        <ul class="divide-y divide-gray-200">
                            @foreach($selectedItem->balanceReceipts as $receipt)
                            <li class="py-2 flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">₱{{ number_format($receipt->amount_paid, 2) }}</p>
                                    <p class="text-xs text-gray-500">Paid on {{ \Carbon\Carbon::parse($receipt->created_at)->format('M d, Y') }}</p>
                                </div>
                                <span class="text-xs text-gray-600 italic">{{ $receipt->payment_method ?? 'Unknown method' }}</span>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-sm text-gray-500">No balance payments recorded.</p>
                        @endif
                    </div>

                    <!-- Additional Payments -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Additional Payments</h3>
                        @if($selectedItem->additionalPayments->isNotEmpty())
                        <ul class="divide-y divide-gray-200">
                            @foreach($selectedItem->additionalPayments as $payment)
                            <li class="py-2 flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">₱{{ number_format($payment->amount, 2) }}</p>
                                    <p class="text-xs text-gray-500">Paid on {{ \Carbon\Carbon::parse($payment->created_at)->format('M d, Y') }}</p>
                                </div>
                                <span class="text-xs text-gray-600 italic">{{ $payment->description ?? 'No description' }}</span>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-sm text-gray-500">No additional payments recorded.</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </x-view-details-modal>
    @endif
</div>