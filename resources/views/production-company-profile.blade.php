<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen flex flex-col bg-gray-50">
    <x-blocked-banner-wrapper />
    @include('layout.nav')

    <main class="flex-grow">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-fade-in">
            <div class="mb-8">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-cPrimary">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('production.services') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-cPrimary md:ml-2">Production Services</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $productionCompany->company_name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Company Overview Section -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                <div class="md:flex">
                    <div class="md:w-1/3 p-6">
                        <div class="bg-gray-100 rounded-xl overflow-hidden flex items-center justify-center w-full h-full min-h-[200px]">
                            @if($productionCompany->company_logo && $productionCompany->company_logo != 'imgs/companyLogo/placeholder.jpg')
                            <div class="w-full h-full">
                                <img src="{{ $productionCompany->logo_url }}" alt="{{ $productionCompany->company_name }}" class="w-full h-full object-cover">
                            </div>
                            @else
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-sm font-medium">Company Logo</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="md:w-2/3 p-6 md:border-l border-gray-200">
                        <div class="flex justify-between items-start mb-4">
                            <h1 class="font-gilroy font-bold text-3xl md:text-4xl text-gray-900">{{ $productionCompany->company_name }}</h1>
                            <div class="flex items-center bg-gray-100 px-3 py-1 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                </svg>
                                <span class="ml-1 font-medium text-sm">{{ number_format($productionCompany->avg_rating ?? 0, 1) }}</span>
                                <span class="ml-1 text-xs text-gray-500">({{ $productionCompany->review_count ?? 0 }} reviews)</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Contact Information</h3>
                                <p class="text-gray-800 mt-1">{{ $productionCompany->email }}</p>
                                <p class="text-gray-800">{{ $productionCompany->phone }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Location</h3>
                                <p class="text-gray-800 mt-1">{{ $productionCompany->address }}</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Production Capabilities</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($productionTypes as $type)
                                @if(in_array($type->id, is_array($productionCompany->production_type) ? $productionCompany->production_type : []))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">{{ $type->name }}</span>
                                @endif
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Apparel Types</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($apparelTypes as $type)
                                @if(in_array($type->id, is_array($productionCompany->apparel_type) ? $productionCompany->apparel_type : []))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">{{ $type->name }}</span>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div x-data="{ activeTab: 'pricing' }">
                <div class="mb-8 border-b border-gray-200">
                    <nav class="flex -mb-px space-x-8">
                        <button
                            @click="activeTab = 'pricing'"
                            :class="{'text-cPrimary border-cPrimary': activeTab === 'pricing', 'text-gray-500 hover:text-gray-700 border-transparent hover:border-gray-300': activeTab !== 'pricing'}"
                            class="py-4 px-1 border-b-2 font-medium text-lg transition duration-150 ease-in-out">
                            Pricing
                        </button>
                        <button
                            @click="activeTab = 'reviews'"
                            :class="{'text-cPrimary border-cPrimary': activeTab === 'reviews', 'text-gray-500 hover:text-gray-700 border-transparent hover:border-gray-300': activeTab !== 'reviews'}"
                            class="py-4 px-1 border-b-2 font-medium text-lg transition duration-150 ease-in-out">
                            Reviews
                        </button>
                    </nav>
                </div>

                <!-- Pricing Tab -->
                <div x-show="activeTab === 'pricing'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="font-gilroy font-bold text-xl text-gray-900">Pricing Information</h2>
                            <p class="text-gray-600 text-sm mt-1">Below are the prices for different apparel types and production methods.</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apparel Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Production Method</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Price (₱)</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulk Price (₱)</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($pricingRecords as $record)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $record->apparelType->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $record->productionType->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ number_format($record->base_price, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ number_format($record->bulk_price, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a
                                                href="{{ route('customer.place-order.select-apparel') }}"
                                                class="text-cPrimary hover:text-purple-700 font-medium"
                                                onclick="localStorage.setItem('selectedCompany', '{{ $productionCompany->id }}'); localStorage.setItem('selectedApparelType', '{{ $record->apparel_type }}'); localStorage.setItem('selectedProductionType', '{{ $record->production_type }}');">
                                                Order Now
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No pricing information available.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 bg-gray-50">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Note:</span> Bulk orders require a minimum of 10 items. Custom designs may incur additional charges.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div x-show="activeTab === 'reviews'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h2 class="font-gilroy font-bold text-xl text-gray-900">Customer Reviews</h2>
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i <= ($productionCompany->avg_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                            </svg>
                                            @endfor
                                    </div>
                                    <span class="ml-2 text-lg font-medium text-gray-900">{{ number_format($productionCompany->avg_rating ?? 0, 1) }} out of 5</span>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm mt-1">Based on {{ $productionCompany->review_count ?? 0 }} customer reviews</p>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @php
                            $companyReviews = \App\Models\Review::where('production_company_id', $productionCompany->id)
                            ->where('is_visible', true)
                            ->orderBy('created_at', 'desc')
                            ->limit(3)
                            ->get();
                            @endphp

                            @forelse($companyReviews as $review)
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                                    </svg>
                                                    @endfor
                                            </div>
                                            <span class="ml-2 text-sm font-medium text-gray-900">{{ Str::limit(strip_tags($review->comment), 30) }}</span>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">By {{ $review->user->name }} - <span class="text-gray-500">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</span></p>
                                    </div>
                                </div>
                                <p class="text-gray-800 mt-2">{{ $review->comment }}</p>
                            </div>
                            @empty
                            <div class="p-6">
                                <p class="text-gray-600 text-center">No reviews yet. Be the first to review this production company!</p>
                            </div>
                            @endforelse
                        </div>

                        <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
                            <p class="text-sm text-gray-600">
                                @php
                                $reviewCount = $productionCompany->review_count ?? 0;
                                $displayCount = $companyReviews->count();
                                @endphp
                                @if($reviewCount > 0)
                                Showing {{ $displayCount }} of {{ $reviewCount }} reviews
                                @else
                                No reviews available
                                @endif
                            </p>
                            @if($reviewCount > 3)
                            <div>
                                <button class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                                    Load More
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layout.footer')
</body>

</html>