<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col h-screen justify-between bg-gray-50">
    <div class="flex flex-col h-full">
        <!-- Header Banner -->
        <div class="flex p-1.5 bg-cPrimary font-gilroy font-bold text-white text-sm justify-center">
            Production Hub
        </div>

        <div class="flex h-full">
            <!-- Sidebar Navigation -->
            @include('layout.printer')

            <!-- Main Content Area -->
            <div class="flex flex-col gap-y-8 p-8 bg-[#F9F9F9] w-full">
                <!-- Dashboard Header -->
                <div class="flex justify-between items-center">
                    <div class="flex flex-col gap-y-1">
                        <h2 class="font-gilroy font-bold text-3xl text-gray-900">Hello, {{ $productionCompany->company_name }}</h2>
                        <h4 class="font-inter text-base text-gray-600">Here's what's going on today.</h4>
                    </div>
                    <div>
                        <div class="relative">
                            <input type="text" id="orderSearch" placeholder="Search orders..." class="px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-cPrimary focus:border-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Orders Section -->
                <div class="flex flex-col gap-y-5">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-x-2">
                            <h1 class="font-gilroy font-bold text-2xl text-gray-900">Orders</h1>
                            @if(isset($orders) && $orders->isNotEmpty())
                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cPrimary bg-opacity-10 text-cPrimary">
                                {{ $orders->count() }}
                            </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-x-3">
                            @if(isset($orders) && $orders->isNotEmpty())
                            <button id="bulkActionBtn" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary disabled:opacity-50" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                                Bulk Actions
                            </button>
                            @endif

                            <div class="relative inline-block text-left" x-data="{ open: false }">
                                <button @click="open = !open" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter
                                </button>

                                <!-- Dropdown menu -->
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" x-cloak>
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Orders</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Bulk Orders</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Single Orders</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Personalized</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Standard</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Navigation Tabs -->
                    <div class="border-b border-gray-200">
                        @include('partner.printer.order-nav')
                    </div>

                    <!-- Orders Table -->
                    <div class="bg-white rounded-lg shadow animate-fade-in overflow-hidden">
                        @if(!isset($orders) || $orders->isEmpty())
                        <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">{{ $emptyMessage ?? 'No orders available' }}</h3>
                            <p class="text-gray-500">New orders will appear here when they reach this stage.</p>
                        </div>
                        @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="px-6 py-3 text-left">
                                            <div class="flex items-center">
                                                <input id="select_all" type="checkbox" class="h-4 w-4 text-cPrimary rounded border-gray-300 focus:ring-cPrimary">
                                                <span class="ml-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Select</span>
                                            </div>
                                        </th>
                                        @foreach($columnHeaders ?? ['Date', 'Order ID', 'Customer', 'Email', 'Apparel', 'Production', 'Order Type'] as $header)
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $header }}</th>
                                        @endforeach
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50 cursor-pointer transition duration-150 ease-in-out" data-url="{{ route($routePrefix, ['order_id' => $order->order_id]) }}">
                                        <td class="px-6 py-4 whitespace-nowrap" onclick="event.stopPropagation()">
                                            <input type="checkbox" class="order-checkbox h-4 w-4 text-cPrimary rounded border-gray-300 focus:ring-cPrimary">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ substr($order->order_id, 0, 8) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-600">{{ strtoupper(substr($order->user->name, 0, 1)) }}</span>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate max-w-[150px]">
                                            {{ $order->user->email }}
                                        </td>

                                        @if(isset($columnHeaders) && in_array('Apparel', $columnHeaders))
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->apparelType->name ?? 'Unknown' }}
                                        </td>
                                        @endif

                                        @if(isset($columnHeaders) && in_array('Production', $columnHeaders))
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->productionType->name ?? 'Unknown' }}
                                        </td>
                                        @endif

                                        @if(isset($columnHeaders) && in_array('Order Type', $columnHeaders))
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->is_bulk_order ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $order->is_bulk_order ? 'Bulk' : 'Single' }}
                                            </span>
                                        </td>
                                        @endif

                                        @if(isset($columnHeaders) && in_array('Customization', $columnHeaders))
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->is_customized ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $order->is_customized ? 'Personalized' : 'Standard' }}
                                            </span>
                                        </td>
                                        @endif

                                        @if(isset($columnHeaders) && in_array('Designer', $columnHeaders))
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->designer->user->name ?? 'Unassigned' }}
                                        </td>
                                        @endif

                                        @if(isset($columnHeaders) && in_array('Filled', $columnHeaders))
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->customizationDetails && !$order->customizationDetails->isEmpty() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $order->customizationDetails && !$order->customizationDetails->isEmpty() ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        @endif

                                        @if(isset($columnHeaders) && in_array('Remaining Payment', $columnHeaders))
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                            {{ number_format($order->final_price - $order->downpayment_amount, 2) }} PHP
                                        </td>
                                        @endif

                                        @if(isset($columnHeaders) && in_array('Total Payment', $columnHeaders))
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                            {{ number_format($order->final_price, 2) }} PHP
                                        </td>
                                        @endif

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" onclick="event.stopPropagation()">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route($routePrefix, ['order_id' => $order->order_id]) }}" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if(isset($orders) && $orders->count() > 10 && method_exists($orders, 'links'))
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $orders->links() }}
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tr[data-url]');
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    window.location.href = row.getAttribute('data-url');
                });
            });

            const selectAllCheckbox = document.getElementById('select_all');
            const orderCheckboxes = document.querySelectorAll('.order-checkbox');
            const bulkActionBtn = document.getElementById('bulkActionBtn');

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const isChecked = this.checked;
                    orderCheckboxes.forEach(checkbox => {
                        checkbox.checked = isChecked;
                    });
                    updateBulkActionButton();
                });
            }

            orderCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActionButton);
            });

            function updateBulkActionButton() {
                if (bulkActionBtn) {
                    const checkedCount = document.querySelectorAll('.order-checkbox:checked').length;
                    bulkActionBtn.disabled = checkedCount === 0;

                    if (checkedCount > 0) {
                        bulkActionBtn.textContent = `Actions (${checkedCount})`;
                    } else {
                        bulkActionBtn.textContent = 'Bulk Actions';
                    }
                }
            }

            // Search functionality
            const searchInput = document.getElementById('orderSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
        });
    </script>
</body>

</html>