<div>
    <!-- Search and Filter Controls -->
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center bg-white p-4 rounded-lg shadow-sm gap-4">
        <div class="flex items-center gap-4">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Search..."
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-md block w-full sm:text-sm">
            </div>

            <div class="flex items-center gap-2 p-4"
                wire:model.live="selectedItems"
                x-data="{}"
                x-show="$wire.selectedItems.length > 0">
                <div class="text-sm text-gray-600">
                    Selected {{ $this->getSelectedItemsOnCurrentPageCount() }} out of
                    {{ $this->getCurrentPageItems()->count() }} items on this page
                    @if($this->getSelectedItemsNotOnCurrentPageCount() > 0)
                    (+ {{ $this->getSelectedItemsNotOnCurrentPageCount() }} on other pages)
                    @endif
                </div>

            </div>

        </div>

        <div class="flex items-center space-x-4">
            <div x-data="{
    selectedItems: @entangle('selectedItems'),
    statuses: window.itemStatuses,
    get bulkActionType() {
        if (!this.selectedItems.length) return null;
        // Get statuses for the selected items
        let selectedStatuses = this.selectedItems.map(id => this.statuses[id]);
        // If all are active, return 'active'
        if (selectedStatuses.every(status => status === 'active')) return 'active';
        // If all are blocked, return 'blocked'
        if (selectedStatuses.every(status => status === 'blocked')) return 'blocked';
        // Mixed statuses: no bulk action allowed
        return null;
    }
}">     
@if($this->type === 'manage')
                <div x-show="selectedItems.length > 0" class="flex gap-2">
                    <template x-if="bulkActionType === 'active'">
                        <button wire:click="bulkDelete" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded flex items-center gap-2 transition duration-200">
                            Block
                        </button>
                    </template>
                    <template x-if="bulkActionType === 'blocked'">
                        <button wire:click="bulkApprove" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded flex items-center gap-2 transition duration-200">
                            Reactivate
                        </button>
                    </template>
                </div>
                @else
                <div x-show="selectedItems.length > 0" class="flex gap-2">
                        <button wire:click="bulkDelete" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded flex items-center gap-2 transition duration-200">
                            Deny
                        </button>
                        <button wire:click="bulkApprove" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded flex items-center gap-2 transition duration-200">
                            Approve
                        </button>
                </div>
                @endif
            </div>


            <div class="flex items-center space-x-2">
                <label for="perPage" class="text-sm text-gray-600">Show</label>
                <select
                    id="perPage"
                    wire:model.live="perPage"
                    class="border-gray-300 pr-4 py-2 border text-center rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
                <span class="text-sm text-gray-600">entries</span>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-hidden shadow-sm rounded-lg bg-white">
        <div class="overflow-x-auto">
            <table wire:loading.class="opacity-40" wire:target="search, perPage, sortField, sortDirection, refresh" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <!-- Select All Checkbox -->
                        <th class="px-6 py-4 w-10">
                            <input
                                type="checkbox"
                                wire:model="selectAll"
                                wire:click="toggleSelectAll"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </th>

                        @foreach($columns as $column)
                        @php
                        // Support both string and array column definitions
                        $field = is_array($column) ? ($column['field'] ?? null) : $column;
                        $label = is_array($column) ? ($column['label'] ?? ucfirst($column)) : ucfirst($column);
                        @endphp
                        <th
                            class="group px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer transition-colors hover:bg-gray-100"
                            wire:click="sortBy('{{ $field }}')">
                            <div class="flex items-center space-x-1">
                                <span>{{ $label }}</span>
                                <span class="text-gray-400">
                                    @if($sortField === $field)
                                    @if($sortDirection === 'asc')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    @endif
                                    @else
                                    <svg width="8" height="10" viewBox="0 0 8 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.5 6.5L4 9L6.5 6.5M1.5 3.5L4 1L6.5 3.5" stroke="#A4A7AE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    @endif
                                </span>
                            </div>
                        </th>
                        @endforeach
                        <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($items as $item)
                    <tr
                        class="hover:bg-gray-50 transition-colors cursor-pointer"
                        @click.stop="$wire.openDetails('{{ $item->{$primaryKey} }}')">
                        <!-- Row Selection Checkbox -->
                        <td class="px-6 py-4 whitespace-nowrap" @click.stop>
                            <input
                                type="checkbox"
                                wire:model.live="selectedItems"
                                wire:key="checkbox-{{ $item->{$this->primaryKey} }}"
                                value="{{ $item->{$this->primaryKey} }}"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </td>

                        @foreach($columns as $column)
                        @php
                        $field = is_array($column) ? ($column['field'] ?? null) : $column;
                        @endphp
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ data_get($item, $field) }}
                        </td>
                        @endforeach

                        <td class="px-6 py-4 whitespace-nowrap" wire:key="item-{{ $item->{$primaryKey} }}-{{ $item->status }}" @click.stop>
                            <div class="flex justify-center space-x-2">
                                @if($this->type === 'approve')
                                <x-popover>
                                    <x-slot name="trigger">
                                        <button
                                            wire:click="openApproveModal('{{ $item->{$primaryKey} }}')"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs rounded-md font-medium text-blue-600 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.5 12L10.5 15L16.5 9M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    Approve this item
                                </x-popover>
                                <x-popover>
                                    <x-slot name="trigger">
                                        <button
                                            wire:click="openDeleteModal('{{ $item->{$primaryKey} }}')"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs rounded-md font-medium text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 9L9 15M9 9L15 15M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>

                                        </button>
                                    </x-slot>
                                    Deny this item
                                </x-popover>
                                @else
                                @if($item->status == 'active')
                                <x-popover>
                                    <x-slot name="trigger">
                                        <button
                                            wire:click="openDeleteModal('{{ $item->{$primaryKey} }}')"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs rounded-md font-medium text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                            <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 101 101" id="block">
                                                <path d="M50.5 16.4c-18.8 0-34.1 15.3-34.1 34.1 0 9.3 3.8 17.8 9.9 24 0 0 0 .1.1.1h.1c6.2 6.2 14.7 10 24.1 10 18.8 0 34.1-15.3 34.1-34.1S69.3 16.4 50.5 16.4zm0 4.8c7.2 0 13.8 2.6 18.9 6.9L28.2 69.4c-4.3-5.1-6.9-11.7-6.9-18.9-.1-16.1 13.1-29.3 29.2-29.3zm0 58.6c-7.2 0-13.8-2.6-18.9-7l41.2-41.2c4.4 5.1 7 11.7 7 18.9 0 16.1-13.2 29.3-29.3 29.3z"></path>
                                            </svg>
                                        </button>
                                    </x-slot>
                                    Block this item
                                </x-popover>
                                @else
                                <x-popover>
                                    <x-slot name="trigger">
                                        <button
                                            wire:click="openApproveModal('{{ $item->{$primaryKey} }}')"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs rounded-md font-medium text-blue-600 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.5 12L10.5 15L16.5 9M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    Activate this item
                                </x-popover>
                                @endif
                                @endif
                                <x-popover>
                                    <x-slot name="trigger">
                                        <a href="mailto:{{ $item->email }}"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs rounded-md font-medium text-green-600 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21.5 18L14.8571 12M9.14286 12L2.50003 18M2 7L10.1649 12.7154C10.8261 13.1783 11.1567 13.4097 11.5163 13.4993C11.8339 13.5785 12.1661 13.5785 12.4837 13.4993C12.8433 13.4097 13.1739 13.1783 13.8351 12.7154L22 7M6.8 20H17.2C18.8802 20 19.7202 20 20.362 19.673C20.9265 19.3854 21.3854 18.9265 21.673 18.362C22 17.7202 22 16.8802 22 15.2V8.8C22 7.11984 22 6.27976 21.673 5.63803C21.3854 5.07354 20.9265 4.6146 20.362 4.32698C19.7202 4 18.8802 4 17.2 4H6.8C5.11984 4 4.27976 4 3.63803 4.32698C3.07354 4.6146 2.6146 5.07354 2.32698 5.63803C2 6.27976 2 7.11984 2 8.8V15.2C2 16.8802 2 17.7202 2.32698 18.362C2.6146 18.9265 3.07354 19.3854 3.63803 19.673C4.27976 20 5.11984 20 6.8 20Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </x-slot>
                                    Email this item
                                </x-popover>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($columns ?? []) + (count($actions ?? []) > 0 ? 2 : 1) }}" class="px-6 py-10 text-center text-sm text-gray-500">
                            No records found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom Pagination -->
    <div class="mt-6">
        @if($items->hasPages())
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-sm text-gray-700">
                <span>Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() }} results</span>
            </div>

            <div class="flex justify-center items-center space-x-2">
                <button
                    @if($items->onFirstPage())
                    disabled
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md bg-gray-50 text-gray-400 cursor-not-allowed"
                    @else
                    wire:click="previousPage"
                    wire:loading.attr="disabled"
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md bg-white text-gray-700 hover:bg-gray-50"
                    @endif
                    >
                    Previous
                </button>

                <div class="hidden md:flex">
                    @php
                    $totalPages = $items->lastPage();
                    $currentPage = $items->currentPage();

                    // Determine the range of pages to show
                    $range = 5; // Show 5 page buttons at most
                    $start = max(1, $currentPage - floor($range / 2));
                    $end = min($totalPages, $start + $range - 1);

                    // Adjust start if we're at the end of the range
                    $start = max(1, $end - $range + 1);
                    @endphp

                    @if($start > 1)
                    <button
                        wire:click="gotoPage(1)"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md bg-white text-gray-700 hover:bg-gray-50 mx-1">
                        1
                    </button>
                    @if($start > 2)
                    <span class="mx-1 text-gray-500">...</span>
                    @endif
                    @endif

                    @for($i = $start; $i <= $end; $i++)
                        <button
                        wire:click="gotoPage({{ $i }})"
                        class="relative inline-flex items-center px-4 py-2 border {{ $i == $items->currentPage() ? 'border-indigo-500 text-indigo-600 bg-indigo-50' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50' }} text-sm font-medium rounded-md mx-1">
                        {{ $i }}
                        </button>
                        @endfor

                        @if($end < $totalPages)
                            @if($end < $totalPages - 1)
                            <span class="mx-1 text-gray-500">...</span>
                            @endif
                            <button
                                wire:click="gotoPage({{ $totalPages }})"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md bg-white text-gray-700 hover:bg-gray-50 mx-1">
                                {{ $totalPages }}
                            </button>
                            @endif
                </div>

                <button
                    @if(!$items->hasMorePages())
                    disabled
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md bg-gray-50 text-gray-400 cursor-not-allowed"
                    @else
                    wire:click="nextPage"
                    wire:loading.attr="disabled"
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md bg-white text-gray-700 hover:bg-gray-50"
                    @endif
                    >
                    Next
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    window.itemStatuses = @json($items->pluck('status', $this->primaryKey));
</script>