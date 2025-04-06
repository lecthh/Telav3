<div>
    @if($selectedItems && $showApproveModal)
    <x-view-details-modal
        :title="count($selectedItems) > 1 
            ? ($type === 'manage' ? 'Reactivate Multiple ' . $entityType : 'Approve Multiple ' . $entityType)
            : ($type === 'manage' ? 'Reactivate ' . $entityType . ': ' . ($displayNames[0] ?? '') : 'Approve ' . $entityType . ': ' . ($displayNames[0] ?? ''))"
        wire:model="showApproveModal">

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full {{ $type === 'reactivate' ? 'bg-blue-100' : 'bg-green-100' }} sm:mx-0 sm:h-10 sm:w-10">
                    @if($type === 'reactivate')
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    @else
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    @endif
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-900" id="modal-title">
                        @if($type === 'manage')
                        Reactivation Confirmation
                        @else
                        Approval Confirmation
                        @endif
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            @if(count($selectedItems) > 1)
                            Are you sure you want to {{ $type === 'manage' ? 'reactivate' : 'approve' }} these {{ count($selectedItems) }} {{ $entityType }} items?
                            <br>
                            <strong>{{ implode(', ', $displayNames) }}</strong>
                            @else
                            Are you sure you want to {{ $type === 'manage' ? 'reactivate' : 'approve' }} this {{ $entityType }}:
                            <strong>{{ $displayNames[0] ?? '' }}</strong>?
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            @if($type === 'manage')
            <button type="button"
                wire:click="reactivateConfirmed"
                class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-blue-500 sm:ml-3 sm:w-auto">
                Reactivate
            </button>
            @else
            <button type="button"
                wire:click="approveConfirmed"
                class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 sm:ml-3 sm:w-auto">
                <span wire:loading wire:target="approveConfirmed" class="mr-2">
                    <x-spinner wire:loading />
                </span>
                <span wire:loading.remove wire:target="approveConfirmed">Approve</span>
            </button>
            @endif
            <button type="button"
                wire:click="cancelApprove"
                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">
                Cancel
            </button>
        </div>
    </x-view-details-modal>
    @endif
</div>