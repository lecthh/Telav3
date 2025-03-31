<div>
    @if($selectedItem && $showEditModal)
    <x-view-details-modal wire:model="showEditModal" title="Edit Designer Details">
        <div class="bg-white p-6 rounded-lg space-y-4">
            <!-- Designer Avatar -->
            <div class="flex justify-center">
                <img src="{{ (isset($selectedItem['user']) && isset($selectedItem['user']['avatar']) && $selectedItem['user']['avatar']) ? asset('storage/' . $selectedItem['user']['avatar']) : asset('images/default.png') }}"
                    alt="Designer Avatar"
                    class="w-52 h-52 rounded-full object-cover">
            </div>
            <!-- Designer Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Designer Name</h3>
                    <input type="text"
                        wire:model.defer="selectedItem.user_name"
                        class="w-full p-2 border border-gray-300 rounded" />
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Max Free Revisions</h3>
                    <input type="number"
                        wire:model.defer="selectedItem.max_free_revisions"
                        class="w-full p-2 border border-gray-300 rounded" />
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Freelancer</h3>
                    <select wire:model.defer="selectedItem.is_freelancer" class="w-full p-2 border border-gray-300 rounded">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Availability</h3>
                    <select wire:model.defer="selectedItem.is_available" class="w-full p-2 border border-gray-300 rounded">
                        <option value="1">Available</option>
                        <option value="0">Not Available</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Additional Revision Fee</h3>
                    <input type="number"
                        step="0.01"
                        wire:model.defer="selectedItem.addtl_revision_fee"
                        class="w-full p-2 border border-gray-300 rounded" />
                </div>
                <!-- Editable: Designer Description -->
                <div class="space-y-2 md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500">Designer Description</h3>
                    <textarea rows="4"
                        wire:model.defer="selectedItem.designer_description"
                        class="w-full p-2 border border-gray-300 rounded"></textarea>
                </div>
            </div>
            <!-- Save Button -->
            <div class="flex justify-end mt-4">
                <button type="button"
                    wire:click="updateDesigner"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Save
                </button>
            </div>
        </div>
    </x-view-details-modal>
    @endif
</div>