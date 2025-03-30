<div>
    @if($selectedItem && $showModal)
    <x-view-details-modal wire:model="showModal" title="Production Company Details">
        <div class="bg-white p-6 rounded-lg space-y-4">
            <!-- Company Logo -->
            <div class="flex justify-center">
                <img src="{{ $selectedItem->company_logo ? asset($selectedItem->company_logo) : asset('images/default.png') }}"
                    alt="Company Logo"
                    class="w-52 h-52 rounded-full object-cover">
            </div>
            <!-- Company Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Company Name</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->company_name }}</p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Production Type</h3>
                    <p class="text-base font-semibold">
                        {{ implode(', ', $selectedItem->getProductionTypeNames()) }}
                    </p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Address</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->address }}</p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->phone }}</p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Average Rating</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->avg_rating }}</p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Review Count</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->review_count }}</p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Apparel Type</h3>
                    <p class="text-base font-semibold">
                        {{ implode(', ', $selectedItem->getApparelTypeNames()) }}
                    </p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->email }}</p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">User ID</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->user_id }}</p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Verified</h3>
                    <p class="text-base font-semibold">
                        @if($selectedItem->is_verified)
                        <span class="text-green-500">Verified</span>
                        @else
                        <span class="text-red-500">Not Verified</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </x-view-details-modal>
    @endif
</div>