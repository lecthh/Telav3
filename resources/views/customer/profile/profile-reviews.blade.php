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
    @include('layout.nav')

    <div class="container mx-auto px-4 py-12 flex-grow">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col space-y-8">
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
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6 border-b">
                            <div class="flex justify-between items-start">
                                <div class="flex-grow">
                                    <div class="flex items-center space-x-4">
                                        <h3 class="font-gilroy font-bold text-xl text-gray-900">EchoPoint Productions</h3>
                                        <div class="flex items-center space-x-1">
                                            @for($i = 0; $i < 5; $i++)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i < 4 ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                                </svg>
                                                @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-500 text-sm mt-1">Verified Purchase</p>
                                </div>
                                <span class="text-gray-500 text-sm">September 4, 2024</span>
                            </div>

                            <p class="text-gray-700 mt-4 leading-relaxed">I like the quality of the cloth. Also the sewing is excellent and the attention to detail is remarkable.</p>

                            <div class="mt-4 flex space-x-4">
                                <div class="w-24 h-24 bg-purple-100 rounded-lg overflow-hidden">
                                    <img src="/api/placeholder/100/100" alt="Review Image" class="w-full h-full object-cover">
                                </div>
                                <div class="w-24 h-24 bg-purple-100 rounded-lg overflow-hidden">
                                    <img src="/api/placeholder/100/100" alt="Review Image" class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-3 flex justify-between items-center">
                            <button class="text-cPrimary hover:bg-purple-100 px-3 py-1.5 rounded-md transition-colors">
                                View Order Details
                            </button>
                            <!-- <div class="flex items-center space-x-2 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11H4a2 2 0 00-2 2v2a2 2 0 002 2h2.5z" />
                                </svg>
                                <span class="text-sm">Helpful (3)</span>
                            </div> -->
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="text-gray-500">No more reviews to show</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>