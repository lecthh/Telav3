<div>
    @if($selectedItem && $showModal)
    <x-view-details-modal wire:model="showModal" title="Designer Details">
        <div class="bg-white p-6 rounded-lg space-y-4">
            <div class="flex justify-center">
                <img src="{{ $selectedItem->user && $selectedItem->user->avatar ? asset('storage/' . $selectedItem->user->avatar) : asset('images/default.png') }}"
                    alt="Designer Avatar"
                    class="w-52 h-52 rounded-full object-cover">
            </div>
            <!-- Designer Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Designer ID -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Designer ID</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->designer_id }}</p>
                </div>
                <!-- Designer Name (computed via getUserNameAttribute) -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Designer Name</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->user_name }}</p>
                </div>
                <!-- Freelancer Status -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Freelancer</h3>
                    <p class="text-base font-semibold">
                        {{ $selectedItem->is_freelancer ? 'Yes' : 'No' }}
                    </p>
                </div>
                <!-- Availability -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Availability</h3>
                    <p class="text-base font-semibold">
                        {{ $selectedItem->is_available ? 'Available' : 'Not Available' }}
                    </p>
                </div>
                <!-- Production Company (computed via getProductionCompanyNameAttribute) -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Production Company</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->production_company_name }}</p>
                </div>
                <!-- Talent Fee -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Talent Fee</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->talent_fee }}</p>
                </div>
                <!-- Max Free Revisions -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Max Free Revisions</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->max_free_revisions }}</p>
                </div>
                <!-- Additional Revision Fee -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Additional Revision Fee</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->addtl_revision_fee }}</p>
                </div>
                <!-- Designer Description -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->designer_description }}</p>
                </div>
                <!-- Order History -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Order History</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->order_history }}</p>
                </div>
                <!-- Average Rating -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Average Rating</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->average_rating }}</p>
                </div>
                <!-- Review Count -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Review Count</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->review_count }}</p>
                </div>
                <!-- Verified Status -->
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