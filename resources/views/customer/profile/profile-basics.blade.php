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

<body class="flex flex-col min-h-screen bg-gray-50">
    @include('layout.nav')
    
    <main class="flex-grow container mx-auto px-4 sm:px-6 md:px-8 py-16 animate-fade-in">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <h1 class="font-gilroy font-bold text-4xl md:text-5xl text-gray-900 mb-6">Profile Page</h1>
                
                <div class="mb-10">
                    <ul class="flex gap-x-8 border-b border-gray-200">
                        <li>
                            <a href="{{ route('customer.profile.basics') }}" 
                               class="inline-block py-4 font-inter text-xl font-bold text-cPrimary border-b-2 border-cPrimary -mb-px transition-colors duration-200 hover:text-purple-700">
                               Basics
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.profile.orders') }}" 
                               class="inline-block py-4 font-inter text-xl font-bold text-gray-800 hover:text-cPrimary border-b-2 border-transparent -mb-px transition-colors duration-200 hover:border-gray-300">
                               Orders
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.profile.reviews') }}" 
                               class="inline-block py-4 font-inter text-xl font-bold text-gray-800 hover:text-cPrimary border-b-2 border-transparent -mb-px transition-colors duration-200 hover:border-gray-300">
                               Reviews
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6 md:p-8 mb-8">
                <div class="max-w-2xl">
                    @livewire('update-profile')
                </div>
            </div>
            
            <div class="flex justify-start">
                @livewire('logout-button')
            </div>
        </div>
    </main>
    
    @include('layout.footer')
</body>

@include('layout.footer')

</html>