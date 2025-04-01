<div>
    @if($selectedItems && $showApproveModal)
    <x-view-details-modal
        :title="count($selectedItems) > 1 
                ? 'Approve Multiple ' . $entityType 
                : 'Approve ' . $entityType . ': ' . ($displayNames[0] ?? '')"
        wire:model="showApproveModal">

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-900" id="modal-title">Approval Confirmation</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            @if(count($selectedItems) > 1)
                            Are you sure you want to approve these {{ count($selectedItems) }} {{ $entityType }} items?
                            <br>
                            <strong>{{ implode(', ', $displayNames) }}</strong>
                            @else
                            Are you sure you want to approve this {{ $entityType }}:
                            <strong>{{ $displayNames[0] ?? '' }}</strong>?
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <button type="button"
                wire:click="approveConfirmed"
                class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 sm:ml-3 sm:w-auto">
                <span wire:loading wire:target="approveConfirmed" class="mr-2">
                    <x-spinner wire:loading />
                </span>
                <span wire:loading.remove wire:target="approveConfirmed">Approve</span>
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