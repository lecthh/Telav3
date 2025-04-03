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
                @if($this->bulkAction === 'delete')
                <button wire:click="bulkDelete"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-2 rounded">
                    Delete
                </button>
                @else
                <button wire:click="bulkApprove"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-2 rounded">
                    Approve
                </button>
                @endif
            </div>

        </div>

        <div class="flex items-center space-x-4">
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

                        <td class="px-6 py-4 whitespace-nowrap" @click.stop>
                            <div class="flex justify-center space-x-2">
                                <button
                                    wire:click="openApproveModal('{{ $item->{$primaryKey} }}')"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs rounded-md font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                        <path d="M18 10L14 6M2.49997 21.5L5.88434 21.124C6.29783 21.078 6.50457 21.055 6.69782 20.9925C6.86926 20.937 7.03242 20.8586 7.18286 20.7594C7.35242 20.6475 7.49951 20.5005 7.7937 20.2063L21 7C22.1046 5.89543 22.1046 4.10457 21 3C19.8954 1.89543 18.1046 1.89543 17 3L3.7937 16.2063C3.49952 16.5005 3.35242 16.6475 3.24061 16.8171C3.1414 16.9676 3.06298 17.1307 3.00748 17.3022C2.94493 17.4954 2.92195 17.7021 2.87601 18.1156L2.49997 21.5Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <button
                                    wire:click="openDeleteModal('{{ $item->{$primaryKey} }}')"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs rounded-md font-medium text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                        <path d="M9 3H15M3 6H21M19 6L18.2987 16.5193C18.1935 18.0975 18.1409 18.8867 17.8 19.485C17.4999 20.0118 17.0472 20.4353 16.5017 20.6997C15.882 21 15.0911 21 13.5093 21H10.4907C8.90891 21 8.11803 21 7.49834 20.6997C6.95276 20.4353 6.50009 20.0118 6.19998 19.485C5.85911 18.8867 5.8065 18.0975 5.70129 16.5193L5 6M10 10.5V15.5M14 10.5V15.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
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