<div>
    @if($selectedItems && $showDeleteModal)
    <x-view-details-modal
        :title="count($selectedItems) > 1
        ? ($actionType === 'approve' ? 'Approve Denial for Multiple ' . $entityType : 'Block Multiple ' . $entityType)
        : ($actionType === 'approve' ? 'Approve Denial for ' . $entityType . ': ' . ($displayNames[0] ?? '') : 'Block ' . $entityType . ': ' . ($displayNames[0] ?? ''))"
        wire:model="showDeleteModal">

        <div class="bg-white px-6 pt-6 pb-5 sm:p-7">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-5 sm:text-left w-full">
                    <h3 class="text-base font-semibold text-gray-900" id="modal-title">
                        @if($actionType === 'approve')
                        Are you sure you want to deny this {{ $entityType }}?
                        @else
                        Please choose an action for this {{ $entityType }}.
                        @endif
                    </h3>
                    <div class="mt-3">
                        <p class="text-sm text-gray-500">
                            @if(count($selectedItems) > 1)
                            These {{ count($selectedItems) }} {{ $entityType }} items: <strong>{{ implode(', ', $displayNames) }}</strong>
                            @else
                            <strong>{{ $displayNames[0] ?? '' }}</strong>
                            @endif
                        </p>

                        @if($actionType === 'approve')
                        <div class="mt-5">
                            <p class="text-sm font-medium text-gray-700 mb-2">Select Deny Reasons:</p>
                            <div class="mt-2 space-y-3">
                                <label class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" wire:model="selectedCommonReasons" value="Lacking business permits" class="form-checkbox h-4 w-4 text-indigo-600">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700">Lacking business permits</span>
                                    </div>
                                </label>
                                <label class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" wire:model="selectedCommonReasons" value="Insufficient documentation" class="form-checkbox h-4 w-4 text-indigo-600">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700">Insufficient documentation</span>
                                    </div>
                                </label>
                                <label class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" wire:model="selectedCommonReasons" value="Failed compliance check" class="form-checkbox h-4 w-4 text-indigo-600">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700">Failed compliance check</span>
                                    </div>
                                </label>
                                <label class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" wire:model="selectedCommonReasons" value="Incomplete application" class="form-checkbox h-4 w-4 text-indigo-600">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700">Incomplete application</span>
                                    </div>
                                </label>
                                <label class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" wire:model="selectedCommonReasons" value="Unverifiable business address" class="form-checkbox h-4 w-4 text-indigo-600">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700">Unverifiable business address</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @elseif($actionType === 'manage')
                        <div class="mt-5">
                            <p class="text-sm font-medium text-gray-700 mb-2">Select Block Reasons:</p>
                            <div class="mt-2 space-y-3">
                                <label class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" wire:model="selectedCommonReasons" value="Did not pay invoice" class="form-checkbox h-4 w-4 text-indigo-600">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700">Did not pay invoice</span>
                                    </div>
                                </label>
                                <label class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" wire:model="selectedCommonReasons" value="Repeated policy violations" class="form-checkbox h-4 w-4 text-indigo-600">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700">Repeated policy violations</span>
                                    </div>
                                </label>
                                <label class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" wire:model="selectedCommonReasons" value="Fraudulent activity detected" class="form-checkbox h-4 w-4 text-indigo-600">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700">Fraudulent activity detected</span>
                                    </div>
                                </label>
                                <label class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" wire:model="selectedCommonReasons" value="Account misuse" class="form-checkbox h-4 w-4 text-indigo-600">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700">Account misuse</span>
                                    </div>
                                </label>
                                <label class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" wire:model="selectedCommonReasons" value="Customer complaint verified" class="form-checkbox h-4 w-4 text-indigo-600">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700">Customer complaint verified</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @endif

                        <!-- Custom Reason Input -->
                        <div class="mt-5">
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Additional Comments:</label>
                            <div class="mt-2">
                                <textarea id="reason" wire:model="reason" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Provide further details..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 sm:flex sm:flex-row-reverse sm:px-7 space-y-2 sm:space-y-0 sm:space-x-3 sm:space-x-reverse rounded-b-lg">
            @if($actionType === 'approve')
            <button type="button"
                wire:click="denyConfirmed"
                class="inline-flex w-full justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">
                Deny
            </button>
            @elseif($actionType === 'manage')
            <button type="button"
                wire:click="blockConfirmed"
                class="inline-flex w-full justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:w-auto">
                Block
            </button>
            @endif
            <button type="button"
                wire:click="cancelDelete"
                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-sm ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">
                Cancel
            </button>
        </div>
    </x-view-details-modal>
    @endif
</div>