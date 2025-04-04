<div>
    @if($selectedItem && $showEditModal)
    <x-view-details-modal wire:model="showEditModal" title="Production Company Details">
        <div class="bg-white p-6 rounded-lg space-y-4">
            <!-- Company Logo -->
            <div class="flex justify-center">
                <img src="{{ isset($selectedItem['company_logo']) && $selectedItem['company_logo'] ? asset($selectedItem['company_logo']) : asset('images/default.png') }}"
                    alt="Company Logo"
                    class="w-52 h-52 rounded-full object-cover">
            </div>
            <!-- Company Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Editable: Company Name -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Company Name</h3>
                    <input type="text"
                        wire:model.defer="selectedItem.company_name"
                        class="w-full p-2 border border-gray-300 rounded" />
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Address</h3>
                    <input type="text"
                        wire:model.defer="selectedItem.address"
                        class="w-full p-2 border border-gray-300 rounded" />
                </div>
                <!-- Editable: Phone -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                    <input type="text"
                        wire:model.defer="selectedItem.phone"
                        class="w-full p-2 border border-gray-300 rounded" />
                </div>
                <!-- Editable: Email -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                    <input type="email"
                        wire:model.defer="selectedItem.email"
                        class="w-full p-2 border border-gray-300 rounded" />
                </div>
                <!-- Editable: User ID -->
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">User ID</h3>
                    <input type="text"
                        wire:model.defer="selectedItem.user_id"
                        class="w-full p-2 border border-gray-300 rounded" />
                </div>

            </div>
            <!-- Save Button -->
            <div class="flex justify-end mt-4">
                <button type="button"
                    wire:click="saveProductionCompany"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Save
                </button>
            </div>
        </div>
    </x-view-details-modal>
    @endif
</div>