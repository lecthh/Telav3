<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css " rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    <header class="bg-cGreen text-black py-2 text-center font-gilroy font-bold text-sm">
        Designer Hub
    </header>

    <div class="flex flex-grow">
        @include('layout.designer')

        <main class="flex-grow bg-gray-50 p-8 lg:p-12">
            <div class="max-w-7xl mx-auto">
                <section class="mb-8">
                    <div class="flex flex-col space-y-2 mb-8">
                        <h1 class="font-gilroy font-bold text-3xl md:text-4xl text-gray-900">
                            Hello, {{ $designer->user->name }}
                        </h1>
                        <p class="text-gray-600 text-base">
                            Here's an overview of your design activities today.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                        <a href="{{ route('partner.designer.orders') }}" class="bg-white shadow-sm rounded-lg p-5 border border-gray-200 hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center gap-x-3 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cGreen" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <h5 class="font-medium text-gray-700">Assigned Orders</h5>
                            </div>
                            <h3 class="font-gilroy font-bold text-2xl text-cGreen">{{ $assignedOrdersCount }}</h3>
                            <p class="text-sm text-gray-500 mt-1">In-progress design work</p>
                        </a>
                        
                        <a href="{{ route('partner.designer.complete') }}" class="bg-white shadow-sm rounded-lg p-5 border border-gray-200 hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center gap-x-3 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cGreen" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h5 class="font-medium text-gray-700">Completed Orders</h5>
                            </div>
                            <h3 class="font-gilroy font-bold text-2xl text-cGreen">{{ $completedOrdersCount }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Successfully finished designs</p>
                        </a>
                        
                        <div class="bg-white shadow-sm rounded-lg p-5 border border-gray-200">
                            <div class="flex items-center gap-x-3 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cGreen" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <h5 class="font-medium text-gray-700">Total Designs</h5>
                            </div>
                            <h3 class="font-gilroy font-bold text-2xl text-cGreen">{{ $totalOrdersHandled }}</h3>
                            <p class="text-sm text-gray-500 mt-1">All-time design work</p>
                        </div>
                    </div>
                    
                    @if($recentOrders->count() > 0)
                    <div class="bg-white shadow-md rounded-lg border border-gray-200 mb-8 overflow-hidden">
                        <div class="border-b border-gray-200 p-4">
                            <h3 class="font-semibold text-gray-800">Recent Design Assignments</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentOrders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ substr($order->order_id, 0, 8) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ $order->status->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('partner.designer.assigned-x', ['order_id' => $order->order_id]) }}" class="text-cGreen hover:text-green-700">View Details</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <div class="mt-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Statistics</h3>
                        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200 min-h-[200px] flex items-center justify-center">
                            <p class="text-center text-gray-500">Statistics chart coming soon</p>
                            <!-- Placeholder for future chart integration -->
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('[data-dashboard-card]');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.classList.add('transform', 'scale-105', 'transition', 'duration-300');
                });
                card.addEventListener('mouseleave', () => {
                    card.classList.remove('transform', 'scale-105', 'transition', 'duration-300');
                });
            });
        });
    </script>
</body>

</html>