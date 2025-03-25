<div>
    @if($selectedItem && $showEditModal)
        <x-view-details-modal wire:model="showEditModal" title="Edit User Details">
            <form wire:submit.prevent="updateUser">
                <div class="bg-white p-6 rounded-lg space-y-4">
                    <!-- Avatar Image Preview -->
                    <div class="flex justify-center">
                    @if($avatarPath)
    <img src="{{ asset('storage/' . $avatarPath) }}" alt="User Avatar" class="w-52 h-52 rounded-full object-cover">
@else
    <img src="{{ isset($selectedItem['avatar']) && $selectedItem['avatar'] ? asset('storage/' . $selectedItem['avatar']) : asset('images/default.png') }}"
         alt="User Avatar" class="w-52 h-52 rounded-full object-cover">
@endif
</div>

                    <!-- Editable User Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-500">Name</label>
                            <input type="text" 
                                   wire:model.defer="selectedItem.name" 
                                   class="border-gray-300 rounded-md w-full px-3 py-2"
                                   placeholder="Enter name">
                        </div>
                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-500">Email</label>
                            <input type="email" 
                                   wire:model.defer="selectedItem.email" 
                                   class="border-gray-300 rounded-md w-full px-3 py-2"
                                   placeholder="Enter email">
                        </div>
                        <!-- Avatar Upload -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-500">Avatar</label>
                            <input type="file" 
                                   wire:model="avatarFile"
                                   class="border-gray-300 rounded-md w-full px-3 py-2">
                        </div>
                        <div class="space-y-2">
    <label class="text-sm font-medium text-gray-500">Email Verified At</label>
    <input type="text" 
           value="{{ isset($selectedItem['email_verified_at']) && $selectedItem['email_verified_at'] ? \Carbon\Carbon::parse($selectedItem['email_verified_at'])->format('M d, Y') : 'Not verified' }}" 
           disabled
           class="border-gray-300 rounded-md w-full px-3 py-2">
</div>
                        <!-- Created At (read-only) -->
                        <div class="space-y-2">
    <label class="text-sm font-medium text-gray-500">Created At</label>
    <input type="text" 
           value="{{ \Carbon\Carbon::parse($selectedItem['created_at'])->format('M d, Y') }}" 
           disabled
           class="border-gray-300 rounded-md w-full px-3 py-2">
</div>
<div class="space-y-2">
    <label class="text-sm font-medium text-gray-500">Updated At</label>
    <input type="text" 
           value="{{ \Carbon\Carbon::parse($selectedItem['updated_at'])->format('M d, Y') }}" 
           disabled
           class="border-gray-300 rounded-md w-full px-3 py-2">
</div>


                    </div>
                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" 
                                wire:click="$set('showEditModal', false)"
                                class="px-4 py-2 bg-gray-300 rounded-md">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </x-view-details-modal>
    @endif
</div>
