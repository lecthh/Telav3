<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>


<body class="min-h-screen flex flex-col bg-gray-50">
    <header class="bg-cPrimary text-white py-2 text-center font-gilroy font-bold text-sm">
        Production Hub
    </header>

    <div class="flex">
        @include('layout.printer')

        <div class="flex-1 flex flex-col min-h-screen">

            <div class="flex-1 p-6 overflow-auto">
                <div class="max-w-6xl mx-auto">
                    <div class="mb-8 grid grid-cols-1 lg:grid-cols-3 gap-6 mt-7">
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-100">
                                <h2 class="font-gilroy font-semibold text-lg text-gray-900">Overall Rating</h2>
                            </div>
                            <div class="p-6 flex flex-col items-center justify-center">
                                <div class="text-6xl font-bold text-gray-900 mb-2">{{ number_format($avgRating, 1) }}</div>
                                <div class="flex mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <=round($avgRating))
                                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        @else
                                        <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        @endif
                                        @endfor
                                </div>
                                <p class="text-gray-600 text-sm">Based on {{ $reviewCount }} customer reviews</p>
                            </div>
                        </div>

                        <!-- Rating Distribution Card -->
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden lg:col-span-2">
                            <div class="px-6 py-5 border-b border-gray-100">
                                <h2 class="font-gilroy font-semibold text-lg text-gray-900">Rating Distribution</h2>
                            </div>
                            <div class="p-6">
                                @for ($i = 5; $i >= 1; $i--)
                                <div class="flex items-center mb-3">
                                    <div class="flex items-center w-20">
                                        <span class="text-sm font-medium text-gray-700 mr-2">{{ $i }} star</span>
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </div>

                                    <div class="flex-grow h-4 bg-gray-100 rounded-full overflow-hidden">
                                        @if($reviewCount > 0)
                                        <div class="h-full bg-cPrimary" style="width: {{ ($ratingDistribution[$i] / max($reviewCount, 1)) * 100 }}%"></div>
                                        @else
                                        <div class="h-full bg-gray-300" style="width: 0%"></div>
                                        @endif
                                    </div>

                                    <span class="ml-3 text-sm font-medium text-gray-700 w-12 text-right">{{ $ratingDistribution[$i] }}</span>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="font-gilroy font-semibold text-lg text-gray-900">Customer Reviews</h2>
                        </div>

                        @if($company->reviews->count() > 0)
                        <div class="divide-y divide-gray-100">
                            @foreach($company->reviews as $review)
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-start">
                                        <div class="mr-4 flex-shrink-0">
                                            <div class="w-12 h-12 bg-cPrimary text-white rounded-full flex items-center justify-center text-xl font-bold">
                                                {{ substr($review->user->name ?? 'U', 0, 1) }}
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $review->user->name ?? 'Anonymous' }}</h4>
                                            <p class="text-sm text-gray-500">{{ $review->created_at->format('F d, Y') }}</p>
                                            <div class="flex items-center mt-1">
                                                <div class="flex">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <=$review->rating)
                                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                        @else
                                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                        @endif
                                                        @endfor
                                                </div>
                                                <span class="text-sm text-gray-600 ml-1">{{ $review->rating }}.0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Order #{{ substr($review->order_id, -6) }}
                                    </div>
                                </div>

                                <div class="ml-16 bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-700">{{ $review->comment }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="p-12 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <h3 class="mt-4 text-xl font-medium text-gray-900">No reviews yet</h3>
                            <p class="mt-2 text-gray-500">When customers leave reviews for your services, they'll appear here.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layout.footer')

</body>

</html>