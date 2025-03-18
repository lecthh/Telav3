<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css " rel="stylesheet" />
    @vite('resources/css/app.css')
    @vite('resources/css/select.css')
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen flex flex-col bg-gray-50">
    @include('layout.nav')

    <main class="flex-grow">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8">
                <h1 class="font-gilroy font-bold text-4xl md:text-5xl text-gray-900 mb-3">Partnered Production Companies</h1>
                <p class="text-gray-600 max-w-3xl">Find the perfect production partner for your custom apparel needs. Filter by apparel type, production method, and price to narrow down your options.</p>
            </div>
            
            <div x-data="{ isOpen: false }" x-on:toggle-filters.window="isOpen = !isOpen">
                <div 
                    x-show="isOpen" 
                    class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-on:click="isOpen = false"
                ></div>
                
                <!-- Mobile Filter Drawer -->
                <div
                    x-show="isOpen"
                    class="fixed inset-y-0 left-0 max-w-xs w-full bg-white shadow-xl z-50 overflow-y-auto lg:hidden"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                >
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="font-bold text-lg">Filters</h2>
                        <button x-on:click="isOpen = false" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-4" id="mobile-filters"></div>
                </div>
            </div>
            
            <div class="animate-fade-in">
                @livewire('production-companies-component')
            </div>
        </div>
    </main>

    @include('layout.footer')
    
    @livewireScripts
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const moveFiltersToMobile = () => {
                const filterElement = document.querySelector('.lg\\:col-span-1');
                const mobileFiltersContainer = document.getElementById('mobile-filters');
                
                if (filterElement && mobileFiltersContainer) {
                    if (window.innerWidth < 1024) {
                        const filterClone = filterElement.cloneNode(true);
                        mobileFiltersContainer.innerHTML = '';
                        mobileFiltersContainer.appendChild(filterClone);
                    } else {
                        mobileFiltersContainer.innerHTML = '';
                    }
                }
            };
            
            moveFiltersToMobile();
            window.addEventListener('resize', moveFiltersToMobile);
            
            document.addEventListener('livewire:initialized', moveFiltersToMobile);
            document.addEventListener('livewire:load', moveFiltersToMobile);
            document.addEventListener('livewire:update', moveFiltersToMobile);
        });
    </script>
</body>
</html>