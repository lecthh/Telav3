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
    <x-blocked-banner-wrapper :entity="$productionCompany" />
    <header class="bg-cPrimary text-white py-2 text-center font-gilroy font-bold text-sm">
        Production Hub
    </header>

    <div class="flex flex-grow">
        @include('layout.printer')

        <main class="flex-grow bg-gray-50 p-8 lg:p-12">
            <div class="max-w-7xl mx-auto">
                <div class="mb-6">
                    <a href="{{ route('partner.printer.designers') }}" class="text-cAccent hover:text-cAccent/80 flex items-center text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Designer List
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Designer Profile -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                            <div class="p-6 border-b border-gray-200">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900">{{ $designer->user->name }}</h1>
                                        <div class="mt-1 flex items-center">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <=round($avgRating))
                                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    @else
                                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    @endif
                                                    @endfor
                                            </div>
                                            <span class="ml-2 text-gray-600">{{ number_format($avgRating, 1) }} ({{ $reviewCount }} reviews)</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $designer->is_freelancer ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $designer->is_freelancer ? 'Freelancer' : 'Company Designer' }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $designer->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $designer->is_available ? 'Available' : 'Unavailable' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                <h2 class="font-semibold text-gray-900 mb-3">About Designer</h2>
                                <p class="text-gray-700 mb-6">
                                    {{ $designer->designer_description ?: 'No description available.' }}
                                </p>

                                @if($designer->is_freelancer)
                                <div class="border-t border-gray-200 pt-6 mt-6">
                                    <h2 class="font-semibold text-gray-900 mb-4">Pricing Information</h2>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <h3 class="text-sm font-medium text-gray-500">Talent Fee</h3>
                                            <p class="mt-1 text-xl font-semibold text-cAccent">₱{{ number_format($designer->talent_fee, 2) }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <h3 class="text-sm font-medium text-gray-500">Free Revisions</h3>
                                            <p class="mt-1 text-xl font-semibold text-cAccent">{{ $designer->max_free_revisions }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <h3 class="text-sm font-medium text-gray-500">Extra Revision Fee</h3>
                                            <p class="mt-1 text-xl font-semibold text-cAccent">₱{{ number_format($designer->addtl_revision_fee, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                                @elseif($designer->productionCompany)
                                <div class="border-t border-gray-200 pt-6 mt-6">
                                    <h2 class="font-semibold text-gray-900 mb-2">Associated Company</h2>
                                    <p class="text-gray-700">{{ $designer->productionCompany->company_name }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Designer Portfolio -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900">Recent Works</h2>
                            </div>
                            <div class="p-6">
                                @if($recentWorks->count() > 0)
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($recentWorks as $work)
                                    <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100">
                                        <img src="{{ asset('storage/' . $work->image) }}" alt="Design work" class="absolute inset-0 w-full h-full object-cover">
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="text-center py-8 text-gray-500">
                                    <p>No portfolio works available for this designer yet.</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Reviews Section -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900">Customer Reviews</h2>
                            </div>
                            <div class="p-6">
                                @if($reviews->count() > 0)
                                <div class="space-y-6">
                                    @foreach($reviews as $review)
                                    <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $review->user->name }}</p>
                                                <div class="flex items-center mt-1">
                                                    <div class="flex">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <=$review->rating)
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
                                                    <span class="ml-2 text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-gray-700">
                                            <p>{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Pagination -->
                                <div class="mt-6">
                                    {{ $reviews->links() }}
                                </div>
                                @else
                                <div class="text-center py-8 text-gray-500">
                                    <p>No reviews available for this designer yet.</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Actions -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6 sticky top-6">
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900">Actions</h2>
                            </div>
                            <div class="p-6">
                                <div class="mb-6">
                                    <h3 class="font-medium text-gray-900 mb-3">About Assignments</h3>
                                    <p class="text-gray-600 text-sm mb-4">
                                        You can assign this designer to pending orders from the Orders page.
                                    </p>
                                    <a href="{{ route('partner.printer.orders') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cAccent hover:bg-cAccent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cAccent">
                                        View Pending Orders
                                    </a>
                                </div>

                                <div class="border-t border-gray-200 pt-6">
                                    <h3 class="font-medium text-gray-900 mb-3">Contact Designer</h3>
                                    <a href="#" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cAccent">
                                        Send Message
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @include('layout.footer')
    @include('chat.chat-widget')
</body>

</html>