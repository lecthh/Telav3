<div>
    @if($selectedItems && $showDeleteModal)
        <x-view-details-modal 
            :title="count($selectedItems) > 1 
                ? 'Delete Multiple ' . $entityType 
                : 'Delete ' . $entityType . ': ' . ($displayNames[0] ?? '')" 
            wire:model="showDeleteModal">
            
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold text-gray-900" id="modal-title">Delete Confirmation</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                @if(count($selectedItems) > 1)
                                    Are you sure you want to delete these {{ count($selectedItems) }} {{ $entityType }} items? This action cannot be undone.
                                    <br>
                                    <strong>{{ implode(', ', $displayNames) }}</strong>
                                @else
                                    Are you sure you want to delete this {{ $entityType }}:
                                    <strong>{{ $displayNames[0] ?? '' }}</strong>? This action cannot be undone.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="button"
                        wire:click="deleteConfirmed"
                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">
                    Delete
                </button>
                <button type="button"
                        @click="open = false"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">
                    Cancel
                </button>
            </div>
        </x-view-details-modal>
    @endif
</div>
