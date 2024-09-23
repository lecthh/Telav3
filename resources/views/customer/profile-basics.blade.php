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

<body class="flex flex-col h-screen justify-between">
    @include('layout.nav')
    <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px]">
        <div class="flex flex-col gap-y-5">
            <div class="flex flex-col gap-y-3 pb-[20px]">
                <h1 class="font-gilroy font-bold text-5xl">Profile Page</h1>
            </div>

            <div class="flex mb-4 gap-x-[20px]">
                <a href="{{ route('customer.profile.basics') }}" class="font-inter text-[24px] font-bold text-cPrimary underline underline-offset-8 transition-colors duration-200 hover:text-purple-700">Basics</a>
                <a href="{{ route('customer.profile.orders') }}" class="font-inter text-[24px] font-bold text-black transition-colors duration-200 hover:underline underline-offset-8 hover:text-cPrimary">Order</a>
                <a href="{{ route('customer.profile.reviews') }}" class="font-inter text-[24px] font-bold text-black transition-colors duration-200 hover:underline underline-offset-8 hover:text-cPrimary">Reviews</a>
            </div>

            <div class="flex flex-col mb-[30px] gap-y-6 w-[600px]">
                <form action="" method="POST" class="space-y-7">
                    @csrf
                    <div>
                        <h2 class="font-inter font-bold text-lg pb-[16px]">Display Name</h2>
                        <input type="text" id="display_name" name="display_name" class="w-full p-3 border border-black rounded-md" value="Jane">
                    </div>
                    <div>
                        <h2 class="font-inter font-bold text-lg pb-[16px]">Email</h2>
                        <input type="email" id="email" name="email" class="w-full p-3 border border-black rounded-md" value="jane@gmail.com">
                    </div>
                    <div>
                        <h2 class="font-inter font-bold text-lg pb-[16px]">Mobile no.</h2>
                        <input type="tel" id="mobile_no" name="mobile_no" class="w-full p-3 border border-black rounded-md" value="+63 054 4802 094">
                    </div>
            </div>

            <div class="flex flex-row gap-x-3 h-[50px]">
                <div class="flex flex-col gap-y-2.5">
                    @livewire('button', ['text' => 'Save'])
                </div>
            </div>

            </form>
        </div>
    </div>
</body>

@include('layout.footer')

</html>