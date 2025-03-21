<div>
    <!-- Search and Filter Controls -->
    <div class="mb-4 flex justify-between items-center">
        <input
            type="text"
            wire:model.live="search"
            placeholder="Search..."
            class="border rounded p-2">
    </div>

    <!-- Table -->
    <table wire:loading.class="opacity-40" class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                @foreach($columns as $column)
                @php
                // Support both string and array column definitions
                $field = is_array($column) ? ($column['field'] ?? null) : $column;
                $label = is_array($column) ? ($column['label'] ?? ucfirst($column)) : ucfirst($column);
                @endphp
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                    wire:click="sortBy('{{ $field }}')">
                    {{ $label }}
                    @if($sortField === $field)
                    @if($sortDirection === 'asc')
                    ▲
                    @else
                    ▼
                    @endif
                    @endif
                </th>
                @endforeach

                @if(count($actions) > 0)
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($items as $item)
            <tr>
                @foreach($columns as $column)
                @php
                $field = is_array($column) ? ($column['field'] ?? null) : $column;
                @endphp
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ data_get($item, $field) }}
                </td>
                @endforeach

                @if(count($actions) > 0)
                <td class="px-6 py-4 whitespace-nowrap">
                    @foreach($actions as $action)
                    <button
                        wire:click="{{ $action['method'] }}({{ $item->id }})"
                        class="text-blue-600 hover:text-blue-900 mr-2">
                        {{ $action['label'] }}
                    </button>
                    @endforeach
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div>