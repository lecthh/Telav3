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

            <!-- Bulk Actions - Only visible when items are selected -->
            <div x-cloak class="flex items-center gap-2">
                <select
                    class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                    <option value="">Bulk Actions</option>
                    <option value="delete">Delete Selected</option>
                    <option value="export">Expo rt Selected</option>
                </select>
                <button
                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs rounded-md font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Apply
                </button>
                <span class="text-sm text-gray-600"></span>
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
    <div
        x-data="{
            selectedItems: [],
            selectAll: false,
            
            toggleSelectAll() {
                if (this.selectAll) {
                    this.selectedItems = this.getItemIds();
                } else {
                    this.selectedItems = [];
                }
            },
            
            isSelected(id) {
                return this.selectedItems.includes(id);
            },
            
            toggleSelection(id) {
                if (this.isSelected(id)) {
                    this.selectedItems = this.selectedItems.filter(item => item !== id);
                    this.selectAll = false;
                } else {
                    this.selectedItems.push(id);
                    if (this.selectedItems.length === this.getItemIds().length) {
                        this.selectAll = true;
                    }
                }
            },
            
            getItemIds() {
                return @js($items->pluck($primaryKey)->toArray());
            },
            
            
            openDetailModal(id) {
                $wire.openDetailModal(id);
            }
        }"
        class="overflow-hidden shadow-sm rounded-lg bg-white">
        <div class="overflow-x-auto">
            <table wire:loading.class="opacity-40" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <!-- Select All Checkbox -->
                        <th class="px-6 py-4 w-10">
                            <input
                                type="checkbox"
                                x-model="selectAll"
                                @change="toggleSelectAll()"
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

                        @if(count($actions) > 0)
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
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
                                :checked="isSelected('{{ $item->{$primaryKey} }}')"
                                @click.stop="openDetails('{{ $item->{$primaryKey} }}')"
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

                        @if(count($actions) > 0)
                        <td class="px-6 py-4 whitespace-nowrap text-sm" @click.stop>
                            <div class="flex space-x-2">
                                @foreach($actions as $action)
                                <button
                                    wire:click="{{$action['method'] }}({{ $item->{$primaryKey} }})"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs rounded-md font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                    {{ $action['label'] }}
                                </button>
                                @endforeach
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($columns) + (count($actions) > 0 ? 2 : 1) }}" class="px-6 py-10 text-center text-sm text-gray-500">
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

    @if($selectedItem && $showDetailsModal)
    <x-view-details-modal wire:model="showDetailsModal" title="Item Details">
        <div class="bg-white p-6 rounded-lg space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">User ID</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->user_id }}</p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Name</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->name }}</p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->email }}</p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Email Verified At</h3>
                    <p class="text-base font-semibold">
                        @if($selectedItem->email_verified_at)
                        {{ $selectedItem->email_verified_at->format('M d, Y') }}
                        @else
                        <span class="text-amber-500">Not verified</span>
                        @endif
                    </p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->created_at->format('M d, Y') }}</p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Updated At</h3>
                    <p class="text-base font-semibold">{{ $selectedItem->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </x-view-details-modal>
    @endif