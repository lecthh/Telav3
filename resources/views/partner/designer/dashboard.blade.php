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

                    <div class="flex gap-x-5 mb-8">
                        @livewire('dashboard-card', ['svg' => 'svgs.shipping-box', 'heading' => 'Assigned Orders', 'value' => $assignedOrdersCount])
                        @livewire('dashboard-card', ['svg' => 'svgs.shredder-device', 'heading' => 'Completed Orders', 'value' => $completedOrdersCount])
                    </div>

                    <ul class="flex gap-x-5 justify-between mb-8">
                        <li class="flex flex-col p-5 bg-white drop-shadow-sm rounded-lg text-base justify-between w-full h-[113px] border border-cGrey">
                            <div class="flex gap-x-3 items-center">
                                <h5>Payouts</h5>
                            </div>
                            <h3 class="font-gilroy font-bold text-xl text-black">3</h3>
                        </li>
                    </ul>

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