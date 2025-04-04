<div>
    @if($selectedItem && $showModal)
    <x-view-details-modal wire:model="showModal" title="Order Details">
        <div class="bg-white p-6 rounded-lg">
            <!-- Tabs Navigation -->
            <div class="mb-4 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button type="button"
                        wire:click="$set('activeTab', 'general')"
                        class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'general' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        General Details
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'history')"
                        class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'history' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        History
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div>
                @if($activeTab === 'general')
                <!-- General Order Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Order ID -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Order ID</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->order_id }}</p>
                    </div>
                    <!-- User -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">User</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->user->name ?? 'N/A' }}</p>
                    </div>
                    <!-- Production Company -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Production Company</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->productionCompany->company_name ?? 'N/A' }}</p>
                    </div>
                    <!-- Assigned Designer -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Assigned Designer</h3>
                        <p class="text-base font-semibold">
                            {{ $selectedItem->designer ? $selectedItem->getDesignerNameAttribute() : 'N/A' }}
                        </p>
                    </div>
                    <!-- Status -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->status->name ?? 'N/A' }}</p>
                    </div>
                    <!-- Quantity -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Quantity</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->quantity }}</p>
                    </div>
                    <!-- Apparel Type -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Apparel Type</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->apparelType->name ?? 'N/A' }}</p>
                    </div>
                    <!-- Production Type -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Production Type</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->productionType->name ?? 'N/A' }}</p>
                    </div>
                    <!-- Downpayment Amount -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Downpayment Amount</h3>
                        <p class="text-base font-semibold">${{ number_format($selectedItem->downpayment_amount, 2) }}</p>
                    </div>
                    <!-- Final Price -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Final Price</h3>
                        <p class="text-base font-semibold">${{ number_format($selectedItem->final_price, 2) }}</p>
                    </div>
                    <!-- Estimated Time of Arrival (ETA) -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">ETA</h3>
                        <p class="text-base font-semibold">
                            {{ \Carbon\Carbon::parse($selectedItem->eta)->format('M d, Y') }}
                        </p>
                    </div>
                </div>
                @elseif($activeTab === 'history')
                <!-- Order Notifications History -->
                <div class="space-y-4">
                    @forelse($selectedItem->notifications as $notification)
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-700">{{ $notification->message }}</p>
                        <p class="text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($notification->created_at)->format('M d, Y h:i A') }}
                        </p>
                    </div>
                    @empty
                    <p class="text-base text-gray-500">No notifications found.</p>
                    @endforelse
                </div>
                @endif
            </div>
        </div>
    </x-view-details-modal>
    @endif
</div>