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

<body class="flex flex-col h-screen justify-start">
    @include('layout.nav')
    <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px] h-full animate-fade-in">
        <div class="flex flex-col gap-y-5">
            <div class="flex flex-col gap-y-5">
                <h1 class="font-gilroy font-bold text-5xl">Profile Page</h1>
                <ul class="flex gap-x-5">
                    <li><a wire:navigate href="{{ route('customer.profile.basics') }}" class="font-inter text-[24px] font-bold text-cPrimary underline underline-offset-8 transition-colors duration-200 hover:text-purple-700">Basics</a></li>
                    <li><a wire:navigate href="{{ route('customer.profile.orders') }}" class="font-inter text-[24px] font-bold text-black transition-colors duration-200 hover:underline underline-offset-8 hover:text-cPrimary">Order</a></li>
                    <li><a wire:navigate href="{{ route('customer.profile.reviews') }}" class="font-inter text-[24px] font-bold text-black transition-colors duration-200 hover:underline underline-offset-8 hover:text-cPrimary">Reviews</a></li>
                </ul>
            </div>

            <div class="flex flex-col mb-[30px] gap-y-6 w-[600px]">
                @livewire('update-profile')
            </div>

            <div class="flex justify-start">
                @livewire('logout-button')
            </div>
            
        </div>
    </div>
</body>

@include('layout.footer')

</html>