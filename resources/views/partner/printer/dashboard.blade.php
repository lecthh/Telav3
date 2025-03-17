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

<body class="bg-gray-50 flex flex-col min-h-screen">
    <header class="bg-cPrimary text-white py-2 text-center font-gilroy font-bold text-sm">
        Production Hub
    </header>

    <div class="flex flex-grow">
        @include('layout.printer')

        <main class="flex-grow bg-gray-50 p-8 lg:p-12">
            <div class="max-w-7xl mx-auto">
                <section class="mb-8">
                    <div class="flex flex-col space-y-2 mb-8">
                        <h1 class="font-gilroy font-bold text-3xl md:text-4xl text-gray-900">
                            Hello, {{ $productionCompany->company_name }}
                        </h1>
                        <p class="text-gray-600 text-base">
                            Here's an overview of your production activities today.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 md:grid-cols-5 gap-4 mb-8">
                        @livewire('dashboard-card', ['svg' => 'svgs.shipping-box', 'heading' => 'Pending Requests', 'value' => $pendingCount, 'route' => 'partner.printer.orders'])
                        @livewire('dashboard-card', ['svg' => 'svgs.print-palette', 'heading' => 'Design in Progress', 'value' => $designInProgressCount, 'route' => 'partner.printer.design-in-progress'])
                        @livewire('dashboard-card', ['svg' => 'svgs.print-palette', 'heading' => 'Finalize Order', 'value' => $finalizeOrderCount, 'route' => 'partner.printer.finalize-order'])
                        @livewire('dashboard-card', ['svg' => 'svgs.square-clock', 'heading' => 'Awaiting Printing', 'value' => $awaitingPrintingCount, 'route' => 'partner.printer.awaiting-printing'])
                        @livewire('dashboard-card', ['svg' => 'svgs.shredder-device', 'heading' => 'Printing Progress', 'value' => $printingInProgressCount, 'route' => 'partner.printer.printing-in-progress'])
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('partner.printer.ready') }}" class="bg-white shadow-md rounded-lg p-6 border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center space-x-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cPrimary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-gray-800">Ready for Collection</h2>
                                </div>
                                <span class="text-2xl font-bold text-cPrimary">{{ $readyForCollectionCount }}</span>
                            </div>
                            <p class="text-gray-500 text-sm">Orders are prepared and waiting for pickup or delivery.</p>
                        </a>

                        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center space-x-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cPrimary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-gray-800">Total Earnings</h2>
                                </div>
                                <span class="text-2xl font-bold text-cPrimary">₱{{ $formattedTotalEarnings }}</span>
                            </div>
                            <p class="text-gray-500 text-sm">Total earnings from all completed orders.</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Production Statistics</h3>
                        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200 min-h-[300px]">
                            <p class="text-center text-gray-500">Statistics chart coming soon</p>
                            <!-- Placeholder for future chart integration -->
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    @include('layout.footer')
    @include('chat.chat-widget')

    <script>
        // Optional: Add some interactivity
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