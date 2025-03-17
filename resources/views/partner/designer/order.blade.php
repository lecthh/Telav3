<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css " rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col h-screen justify-between">
    <div class="flex flex-col h-full">
        <div class="flex p-1 bg-cGreen font-gilroy font-bold text-black text-sm justify-center">Designer Hub</div>
        <div class="flex h-full">
            @php
                $designer = session('admin');
            @endphp
            @include('layout.designer')
            <div class="flex flex-col gap-y-8 p-8 md:p-12 bg-[#F9F9F9] w-full overflow-auto">
                <div class="flex flex-col gap-y-1">
                    <h2 class="font-gilroy font-bold text-3xl text-gray-900">Hello, {{ $designer->user->name ?? 'Designer' }}</h2>
                    <h4 class="font-inter text-base text-gray-600">Here's what's going on today.</h4>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <h1 class="font-gilroy font-bold text-xl text-gray-900">Completed Orders</h1>
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <input type="text" id="search-orders" placeholder="Search orders..." 
                                        class="pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-cGreen focus:border-cGreen">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="relative">
                                    <button class="bg-cGreen hover:bg-cGreen/90 text-black px-4 py-2 rounded-lg flex items-center gap-2 transition duration-150" id="dateFilterButton">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Date</span>
                                    </button>
                                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-10 hidden" id="dateFilterDropdown">
                                        <div class="px-4 py-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <input type="date" class="border border-gray-300 rounded-md text-sm p-1">
                                                <input type="date" class="border border-gray-300 rounded-md text-sm p-1">
                                            </div>
                                            <div class="mt-2 flex justify-end">
                                                <button class="text-sm text-cGreen">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @include('partner.designer.order-nav')
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="select_all" name="select_all" value=""
                                                class="border border-gray-300 rounded w-4 h-4 focus:ring-cGreen text-cGreen">
                                            <label for="select_all" class="ml-2 text-xs">Select All</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order No.</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apparel</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned By</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="orders-table-body">
                                @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 cursor-pointer transition duration-150"
                                    data-url="{{ route('partner.designer.complete-x', ['order_id' => $order->order_id]) }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="order-checkbox border border-gray-300 rounded w-4 h-4 focus:ring-cGreen text-cGreen"
                                               onclick="event.stopPropagation();">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ substr($order->order_id, -8) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->apparelType->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->productionCompany->company_name ?? 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-base">No completed orders found</p>
                                            <p class="text-sm mt-2">When you complete orders, they'll appear here.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination (if needed) -->
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ count($orders) }}</span> orders
                            </div>
                            <!-- Add pagination controls here if needed -->
                        </div>
                    </div>
                </div>
                
                <!-- Orders Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Completed</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ count($orders) }}</p>
                            </div>
                            <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Average Completion Time</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">3.2 days</p>
                            </div>
                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Customer Rating</p>
                                <div class="flex items-center mt-1">
                                    <p class="text-2xl font-bold text-gray-900">4.8</p>
                                    <div class="flex ml-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="h-12 w-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Row click handler
            const rows = document.querySelectorAll('tr[data-url]');
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    window.location.href = row.getAttribute('data-url');
                });
            });
            
            // Select all checkbox
            const selectAllCheckbox = document.getElementById('select_all');
            const orderCheckboxes = document.querySelectorAll('.order-checkbox');
            
            selectAllCheckbox.addEventListener('change', function() {
                orderCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
            
            // Search functionality
            const searchInput = document.getElementById('search-orders');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('#orders-table-body tr');
                
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
            
            // Date filter dropdown
            const dateFilterButton = document.getElementById('dateFilterButton');
            const dateFilterDropdown = document.getElementById('dateFilterDropdown');
            
            dateFilterButton.addEventListener('click', function() {
                dateFilterDropdown.classList.toggle('hidden');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dateFilterButton.contains(e.target) && !dateFilterDropdown.contains(e.target)) {
                    dateFilterDropdown.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>