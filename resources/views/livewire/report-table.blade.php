<div>
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center bg-white p-4 rounded-lg shadow-md gap-4">
        <div class="flex items-center gap-4">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    id="search"
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-md block w-full sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 transition"
                    placeholder="Search reports...">
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
                <label for="status" class="text-sm text-gray-600">Status</label>
                <select
                    wire:model.live="status"
                    id="status"
                    class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-32 text-sm">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="resolved">Resolved</option>
                </select>
            </div>
        </div>
    </div>


    <div class="overflow-x-auto rounded-lg shadow">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('id')">
                        <div class="flex items-center">
                            ID
                            @if ($sortField === 'id')
                            <svg class="w-3 h-3 ml-1 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.12 2.12 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('reason')">
                        <div class="flex items-center">
                            Reason
                            @if ($sortField === 'reason')
                            <svg class="w-3 h-3 ml-1 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.12 2.12 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Reporter Type
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Reported Type
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('status')">
                        <div class="flex items-center">
                            Status
                            @if ($sortField === 'status')
                            <svg class="w-3 h-3 ml-1 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.12 2.12 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('created_at')">
                        <div class="flex items-center">
                            Date Reported
                            @if ($sortField === 'created_at')
                            <svg class="w-3 h-3 ml-1 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.12 2.12 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                            </svg>
                            @endif
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                <tr class="bg-white border-b hover:bg-gray-50 cursor-pointer" wire:click="showReport({{ $report->id }})">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">#{{ $report->id }}</td>
                    <td class="px-6 py-4">
                        {{ $report->stripHtmlReason() }}
                    </td>
                    <td class="px-6 py-4">
                        @if($report->reporter)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $report->reporter->display_name ?? 'N/A' }} ({{ class_basename($report->reporter_type) }})
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($report->reported)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                            {{ $report->reported->display_name ?? 'N/A' }} ({{ class_basename($report->reported_type) }})
                        </span>
                        @endif
                    </td>


                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $report->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr class="bg-white border-b">
                    <td colspan="6" class="px-6 py-4 text-center">No reports found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $reports->links() }}
    </div>
    @livewire('report-details-modal')
</div>