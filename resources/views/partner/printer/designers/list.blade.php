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
                            Designer Catalog
                        </h1>
                        <p class="text-gray-600 text-base">
                            Browse designers in TEL-A PrintHub
                        </p>
                    </div>

                    <!-- Designers Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($designers as $designer)
                            <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow">
                                <div class="p-5 border-b border-gray-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $designer->user->name }}</h3>
                                            <div class="mt-1 flex items-center">
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= round($designer->avgRating))
                                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                            </svg>
                                                        @else
                                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="ml-1 text-sm text-gray-500">{{ $designer->reviewCount }} reviews</span>
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $designer->is_freelancer ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ $designer->is_freelancer ? 'Freelancer' : 'Company Designer' }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $designer->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} ml-2">
                                                    {{ $designer->is_available ? 'Available' : 'Unavailable' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-5">
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-900">Designer Bio</h4>
                                        <p class="mt-1 text-sm text-gray-600 line-clamp-3">{{ $designer->designer_description ?: 'No description available.' }}</p>
                                    </div>
                                    
                                    @if(!$designer->is_freelancer || ($productionCompanyId && $designer->production_company_id == $productionCompanyId))
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-900">Recent Works</h4>
                                            <div class="mt-2 text-sm text-gray-500">View profile for portfolio</div>
                                        </div>
                                    @endif
                                    
                                    @if($designer->is_freelancer)
                                        <div class="space-y-1 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Talent Fee:</span>
                                                <span class="font-medium text-gray-900">₱{{ number_format($designer->talent_fee, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Free Revisions:</span>
                                                <span class="font-medium text-gray-900">{{ $designer->max_free_revisions }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Additional Revision Fee:</span>
                                                <span class="font-medium text-gray-900">₱{{ number_format($designer->addtl_revision_fee, 2) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-5 flex justify-end">
                                        <a href="{{ route('partner.printer.designers.detail', $designer->designer_id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cAccent hover:bg-cAccent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cAccent">
                                            View Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 bg-white rounded-lg shadow p-8 text-center">
                                <p class="text-gray-500">No designers found. Check back later or adjust your filters.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </main>
    </div>

    @include('layout.footer')
    @include('chat.chat-widget')
</body>
</html>