<div>
    <!-- Search and Filter Controls -->
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center bg-white p-4 rounded-lg shadow-md gap-4">
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
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-md block w-full sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
            </div>

            <!-- Selected items indicator -->
            <div class="flex items-center gap-2"
                wire:model.live="selectedItems"
                x-data="{}"
                x-show="$wire.selectedItems.length > 0">
                <div class="text-sm font-medium text-indigo-600">
                    Selected {{ $this->getSelectedItemsOnCurrentPageCount() }} of
                    {{ $this->getCurrentPageItems()->count() }} items
                    @if($this->getSelectedItemsNotOnCurrentPageCount() > 0)
                    <span class="text-gray-500">(+ {{ $this->getSelectedItemsNotOnCurrentPageCount() }} on other pages)</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <!-- Bulk actions -->
            <div x-data="{
    selectedItems: @entangle('selectedItems'),
    statuses: window.itemStatuses,
    get bulkActionType() {
        if (!this.selectedItems.length) return null;
        let selectedStatuses = this.selectedItems.map(id => this.statuses[id]);
        if (selectedStatuses.every(status => status === 'active')) return 'active';
        if (selectedStatuses.every(status => status === 'blocked')) return 'blocked';
        return null;
    }
}">
                @if($this->type === 'manage')
                <div x-show="selectedItems.length > 0" class="flex gap-2">
                    <template x-if="bulkActionType === 'active'">
                        <button wire:click="bulkDelete" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md flex items-center gap-2 transition-all shadow-sm hover:shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            Block
                        </button>
                    </template>
                    <template x-if="bulkActionType === 'blocked'">
                        <button wire:click="bulkApprove" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md flex items-center gap-2 transition-all shadow-sm hover:shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Reactivate
                        </button>
                    </template>
                </div>
                @else
                <div x-show="selectedItems.length > 0" class="flex gap-2">
                    <button wire:click="bulkDelete" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md flex items-center gap-2 transition-all shadow-sm hover:shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Deny
                    </button>
                    <button wire:click="bulkApprove" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md flex items-center gap-2 transition-all shadow-sm hover:shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Approve
                    </button>
                </div>
                @endif
            </div>

            <!-- Per page selector -->
            <div class="flex items-center space-x-2">
                <label for="perPage" class="text-sm text-gray-600">Show</label>
                <select
                    id="perPage"
                    wire:model.live="perPage"
                    class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
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
    <div class="overflow-hidden shadow-md rounded-lg bg-white">
        <div class="overflow-x-auto">
            <table 
                wire:loading.class="opacity-40" 
                wire:target="search, perPage, sortField, sortDirection, refresh" 
                class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <!-- Select All Checkbox -->
                        <th class="px-6 py-3 w-10">
                            <input
                                type="checkbox"
                                wire:model="selectAll"
                                wire:click="toggleSelectAll"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition">
                        </th>

                        @foreach($columns as $column)
                        @php
                        $field = is_array($column) ? ($column['field'] ?? null) : $column;
                        $label = is_array($column) ? ($column['label'] ?? ucfirst($column)) : ucfirst($column);
                        @endphp
                        <th
                            class="group px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('{{ $field }}')">
                            <div class="flex items-center space-x-1 transition-colors hover:text-indigo-600">
                                <span>{{ $label }}</span>
                                <!-- Sort indicator -->
                                <span class="text-gray-400">
                                    @if($sortField === $field)
                                        @if($sortDirection === 'asc')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                        </svg>
                                        @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        @endif
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-0 group-hover:opacity-50" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z" />
                                    </svg>
                                    @endif
                                </span>
                            </div>
                        </th>
                        @endforeach
                        @if($this->showActions)
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">
                            Actions
                        </th>
                        @endif
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
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition">
                        </td>

                        @foreach($columns as $column)
                        @php
                        $field = is_array($column) ? ($column['field'] ?? null) : $column;
                        @endphp
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ data_get($item, $field) }}
                        </td>
                        @endforeach
                        @if($this->showActions)
                        <td class="px-6 py-4 whitespace-nowrap" wire:key="item-{{ $item->{$primaryKey} }}-{{ $item->status }}" @click.stop>
                            <div class="flex justify-center gap-2">
                                @if($this->type === 'approve')
                                <!-- Approve button with tooltip -->
                                <div class="relative group">
                                    <button
                                        wire:click="openApproveModal('{{ $item->{$primaryKey} }}')"
                                        class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 hover:bg-green-200 text-green-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap">
                                        Approve this {{ $this->entityName }}
                                    </div>
                                </div>
                                
                                <!-- Deny button with tooltip -->
                                <div class="relative group">
                                    <button
                                        wire:click="openDeleteModal('{{ $item->{$primaryKey} }}')"
                                        class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 hover:bg-red-200 text-red-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap">
                                        Deny this {{ $this->entityName }}
                                    </div>
                                </div>
                                @else
                                @if($item->status == 'active')
                                <!-- Block button with tooltip -->
                                <div class="relative group">
                                    <button
                                        wire:click="openDeleteModal('{{ $item->{$primaryKey} }}')"
                                        class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 hover:bg-red-200 text-red-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap">
                                        Block this {{ $this->entityName }}
                                    </div>
                                </div>
                                @else
                                <!-- Activate button with tooltip -->
                                <div class="relative group">
                                    <button
                                        wire:click="openApproveModal('{{ $item->{$primaryKey} }}')"
                                        class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 hover:bg-green-200 text-green-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap">
                                        Activate this {{ $this->entityName }}
                                    </div>
                                </div>
                                @endif
                                @endif
                                
                                <!-- Email button with tooltip -->
                                <div class="relative group">
                                    <a href="mailto:{{ $item->email }}"
                                        class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </a>
                                    <div class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap">
                                        Email this {{ $this->entityName }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($columns ?? []) + (count($actions ?? []) > 0 ? 2 : 1) }}" class="px-6 py-10 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p>No records found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        @if($items->hasPages())
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-sm text-gray-700">
                <span>Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() }} results</span>
            </div>

            <div class="flex justify-center items-center space-x-2">
                <!-- Previous button -->
                <button
                    @if($items->onFirstPage())
                    disabled
                    class="flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md bg-gray-50 text-gray-400 cursor-not-allowed"
                    @else
                    wire:click="previousPage"
                    wire:loading.attr="disabled"
                    class="flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md bg-white text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors"
                    @endif
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous
                </button>

                <!-- Page number buttons -->
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
                        class="relative inline-flex items-center justify-center w-8 h-8 border border-gray-300 text-sm font-medium rounded-md bg-white text-gray-700 hover:bg-gray-50 hover:text-indigo-600 mx-1 transition-colors">
                        1
                    </button>
                    @if($start > 2)
                    <span class="mx-1 text-gray-500">...</span>
                    @endif
                    @endif

                    @for($i = $start; $i <= $end; $i++)
                        <button
                        wire:click="gotoPage({{ $i }})"
                        class="relative inline-flex items-center justify-center w-8 h-8 border {{ $i == $items->currentPage() ? 'border-indigo-500 text-white bg-indigo-600' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 hover:text-indigo-600' }} text-sm font-medium rounded-md mx-1 transition-colors">
                        {{ $i }}
                        </button>
                        @endfor

                        @if($end < $totalPages)
                            @if($end < $totalPages - 1)
                            <span class="mx-1 text-gray-500">...</span>
                            @endif
                            <button
                                wire:click="gotoPage({{ $totalPages }})"
                                class="relative inline-flex items-center justify-center w-8 h-8 border border-gray-300 text-sm font-medium rounded-md bg-white text-gray-700 hover:bg-gray-50 hover:text-indigo-600 mx-1 transition-colors">
                                {{ $totalPages }}
                            </button>
                            @endif
                </div>

                <!-- Next button -->
                <button
                    @if(!$items->hasMorePages())
                    disabled
                    class="flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md bg-gray-50 text-gray-400 cursor-not-allowed"
                    @else
                    wire:click="nextPage"
                    wire:loading.attr="disabled"
                    class="flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md bg-white text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors"
                    @endif
                    >
                    Next
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    window.itemStatuses = @json($items->pluck('status', $this->primaryKey));
</script>