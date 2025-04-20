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

<body class="bg-gray-50 flex flex-col min-h-screen">
    <x-blocked-banner-wrapper />
    @include('layout.nav')

    <div class="container mx-auto px-4 py-12 flex-grow">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col space-y-8 animate-fade-in">
                <div class="flex flex-col space-y-6">
                    <h1 class="font-gilroy font-bold text-4xl md:text-5xl text-gray-900">My Reviews</h1>

                    <nav class="flex space-x-6 border-b pb-2">
                        <a href="{{ route('customer.profile.basics') }}" class="font-inter text-lg font-medium text-gray-600 hover:text-cPrimary transition-colors {{ Route::is('customer.profile.basics') ? 'text-cPrimary border-b-2 border-cPrimary' : 'hover:border-b-2 hover:border-gray-300' }}">
                            Basics
                        </a>
                        <a href="{{ route('customer.profile.orders') }}" class="font-inter text-lg font-medium text-gray-600 hover:text-cPrimary transition-colors {{ Route::is('customer.profile.orders') ? 'text-cPrimary border-b-2 border-cPrimary' : 'hover:border-b-2 hover:border-gray-300' }}">
                            Orders
                        </a>
                        <a href="{{ route('customer.profile.reviews') }}" class="font-inter text-lg font-medium text-cPrimary border-b-2 border-cPrimary">
                            Reviews
                        </a>
                    </nav>
                </div>

                <div class="space-y-6">
                    @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6 border-b">
                            <div class="flex justify-between items-start">
                                <div class="flex-grow">
                                    <div class="flex items-center space-x-4">
                                        @if($review->review_type == 'designer' && $review->designer)
                                        <h3 class="font-gilroy font-bold text-xl text-gray-900">{{ $review->designer->user->name }}</h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Designer
                                        </span>
                                        @if($review->designer->is_freelancer)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            Freelancer
                                        </span>
                                        @elseif($review->designer->production_company)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $review->designer->production_company->company_name }}
                                        </span>
                                        @endif
                                        @elseif($review->review_type == 'company' && $review->productionCompany)
                                        <h3 class="font-gilroy font-bold text-xl text-gray-900">{{ $review->productionCompany->company_name }}</h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Production Company
                                        </span>
                                        @endif
                                        <div class="flex items-center space-x-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-500 text-sm mt-1">Order #{{ substr($review->order_id, -6) }}</p>
                                    @if($review->review_type == 'designer')
                                    <p class="text-gray-500 text-sm mt-1">Designer Review</p>
                                    @elseif($review->review_type == 'company')
                                    <p class="text-gray-500 text-sm mt-1">Production Company Review</p>
                                    @endif
                                </div>
                                <span class="text-gray-500 text-sm">{{ $review->created_at->format('F d, Y') }}</span>
                            </div>

                            <p class="text-gray-700 mt-4 leading-relaxed">{{ $review->comment }}</p>

                            @if($review->order && $review->order->imagesWithStatusTwo->count() > 0)
                            <div class="mt-4 flex space-x-4">
                                @foreach($review->order->imagesWithStatusTwo->take(2) as $image)
                                <div class="w-24 h-24 bg-purple-100 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="Order Image" class="w-full h-full object-cover">
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <!-- <div class="bg-gray-50 px-6 py-3 flex justify-between items-center">
                                    <a href="{{ route('customer.profile.orders') }}" class="text-cPrimary hover:bg-purple-100 px-3 py-1.5 rounded-md transition-colors">
                                        View Order Details
                                    </a>
                                </div> -->
                    </div>
                    @endforeach
                    @else
                    <div class="bg-white shadow-md rounded-lg p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">No reviews yet</h3>
                        <p class="mt-2 text-gray-500">You haven't submitted any reviews yet. When you complete orders, you can leave reviews for production companies.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>