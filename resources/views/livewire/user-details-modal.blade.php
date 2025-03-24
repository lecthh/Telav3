<div>
    @if($selectedItem && $showModal)
    <x-view-details-modal wire:model="showModal" title="User Details">
    <div class="bg-white p-6 rounded-lg space-y-4">
        <!-- Avatar Image -->
        <div class="flex justify-center">
            <img src="{{ $selectedItem->avatar ? $selectedItem->avatar : asset('images/default.png') }}"
                 alt="User Avatar"
                 class=" w-52 h-52 rounded-full object-cover">
        </div>
        <!-- User Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <h3 class="text-sm font-medium text-gray-500">User ID</h3>
                <p class="text-base font-semibold">{{ $selectedItem->user_id }}</p>
            </div>
            <div class="space-y-2">
                <h3 class="text-sm font-medium text-gray-500">Name</h3>
                <p class="text-base font-semibold">{{ $selectedItem->name }}</p>
            </div>
            <div class="space-y-2">
                <h3 class="text-sm font-medium text-gray-500">Email</h3>
                <p class="text-base font-semibold">{{ $selectedItem->email }}</p>
            </div>
            <div class="space-y-2">
                <h3 class="text-sm font-medium text-gray-500">Email Verified At</h3>
                <p class="text-base font-semibold">
                    @if($selectedItem->email_verified_at)
                        {{ $selectedItem->email_verified_at->format('M d, Y') }}
                    @else
                        <span class="text-amber-500">Not verified</span>
                    @endif
                </p>
            </div>
            <div class="space-y-2">
                <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                <p class="text-base font-semibold">{{ $selectedItem->created_at->format('M d, Y') }}</p>
            </div>
            <div class="space-y-2">
                <h3 class="text-sm font-medium text-gray-500">Updated At</h3>
                <p class="text-base font-semibold">{{ $selectedItem->updated_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</x-view-details-modal>

    @endif
</div>
