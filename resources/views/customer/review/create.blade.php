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
    @include('layout.nav')

    <main class="flex-grow">
        <div class="container mx-auto my-10 px-4">
            <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm">
                <h1 class="font-gilroy font-bold text-2xl mb-6 text-center text-cPrimary">Leave a Review</h1>
                <p class="mb-6 text-center text-gray-600">for Order #{{ substr($order->order_id, -6) }}</p>
                
                <!-- Production Company Section -->
                <div class="mb-8">
                    <h2 class="font-semibold text-lg text-gray-800 mb-4">Production Company</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="mr-4">
                                @php
                                    use Illuminate\Support\Str;
                                    use Illuminate\Support\Facades\Storage;
                                    
                                    $companyLogo = $order->productionCompany->company_logo ?? null;
                                    
                                    // Check storage location and format the URL accordingly
                                    if (!$companyLogo) {
                                        $logoUrl = asset('imgs/companyLogo/placeholder.jpg');
                                    } elseif (Str::startsWith($companyLogo, 'company_logos/')) {
                                        $logoUrl = Storage::url($companyLogo);
                                    } elseif (Str::startsWith($companyLogo, 'imgs/')) {
                                        $logoUrl = asset($companyLogo);
                                    } else {
                                        $logoUrl = asset('imgs/companyLogo/' . $companyLogo);
                                    }
                                @endphp
                                <img src="{{ $logoUrl }}" 
                                    alt="{{ $order->productionCompany->company_name ?? 'Production Company' }}" 
                                    class="w-16 h-16 object-cover rounded-full">
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold">{{ $order->productionCompany->company_name ?? 'Production Company' }}</h2>
                                <p class="text-sm text-gray-600">{{ $order->apparelType->name ?? 'Apparel' }} - {{ $order->quantity }} items</p>
                            </div>
                        </div>
                    </div>
                
                    <form action="{{ route('customer.review.store') }}" method="POST" class="space-y-6 mt-4">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                            <div class="flex space-x-2" id="company-rating-container">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="company_rating" value="{{ $i }}" class="hidden peer" required>
                                        <span class="text-3xl peer-checked:text-yellow-400 text-gray-300 company-star-icon">★</span>
                                    </label>
                                @endfor
                            </div>
                            @error('company_rating')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="company_comment" class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                            <textarea id="company_comment" name="company_comment" rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cPrimary"
                                placeholder="Share your experience with this production company..." required></textarea>
                            @error('company_comment')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <!-- Designer Section (if applicable) -->
                        @if ($order->designer)
                        <div class="mt-10 pt-8 border-t border-gray-200">
                            <h2 class="font-semibold text-lg text-gray-800 mb-4">Designer</h2>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <div class="w-16 h-16 flex items-center justify-center bg-cPrimary text-white text-xl font-bold rounded-full">
                                            {{ substr($order->designer->user->name ?? 'D', 0, 1) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold">{{ $order->designer->user->name ?? 'Designer' }}</h2>
                                        <p class="text-sm text-gray-600">Design Service</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                <div class="flex space-x-2" id="designer-rating-container">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="designer_rating" value="{{ $i }}" class="hidden peer" required>
                                            <span class="text-3xl peer-checked:text-yellow-400 text-gray-300 designer-star-icon">★</span>
                                        </label>
                                    @endfor
                                </div>
                                @error('designer_rating')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mt-4">
                                <label for="designer_comment" class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                                <textarea id="designer_comment" name="designer_comment" rows="4" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cPrimary"
                                    placeholder="Share your experience with this designer..." required></textarea>
                                @error('designer_comment')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex justify-end">
                            <a href="{{ route('customer.profile.orders') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md mr-2 hover:bg-gray-300">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-cPrimary text-white rounded-md hover:bg-purple-700">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Company stars functionality
            setupStarRating('company-rating-container', 'company-star-icon', 'company_rating');
            
            // Designer stars functionality (if present)
            if (document.getElementById('designer-rating-container')) {
                setupStarRating('designer-rating-container', 'designer-star-icon', 'designer_rating');
            }
            
            function setupStarRating(containerId, starClass, inputName) {
                const stars = document.querySelectorAll('.' + starClass);
                const container = document.getElementById(containerId);
                
                if (!stars.length || !container) return;
                
                stars.forEach((star, index) => {
                    star.addEventListener('click', function() {
                        // Select this star's radio input
                        const radioInput = this.previousElementSibling;
                        radioInput.checked = true;
                        
                        // Update star colors
                        updateStars(stars, index);
                    });
                    
                    star.addEventListener('mouseover', function() {
                        // Temporarily highlight stars
                        for (let i = 0; i <= index; i++) {
                            stars[i].classList.add('text-yellow-400');
                            stars[i].classList.remove('text-gray-300');
                        }
                        
                        for (let i = index + 1; i < stars.length; i++) {
                            stars[i].classList.add('text-gray-300');
                            stars[i].classList.remove('text-yellow-400');
                        }
                    });
                });
                
                container.addEventListener('mouseleave', function() {
                    // Find selected rating
                    const checkedInput = document.querySelector('input[name="' + inputName + '"]:checked');
                    if (checkedInput) {
                        const checkedIndex = parseInt(checkedInput.value) - 1;
                        updateStars(stars, checkedIndex);
                    } else {
                        // Reset all stars
                        stars.forEach(star => {
                            star.classList.add('text-gray-300');
                            star.classList.remove('text-yellow-400');
                        });
                    }
                });
            }
            
            function updateStars(stars, selectedIndex) {
                for (let i = 0; i <= selectedIndex; i++) {
                    stars[i].classList.add('text-yellow-400');
                    stars[i].classList.remove('text-gray-300');
                }
                
                for (let i = selectedIndex + 1; i < stars.length; i++) {
                    stars[i].classList.add('text-gray-300');
                    stars[i].classList.remove('text-yellow-400');
                }
            }
        });
    </script>
</body>
</html>