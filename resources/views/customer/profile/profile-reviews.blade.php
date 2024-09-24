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
    <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px] h-screen animate-fade-in">
        <div class="flex flex-col gap-y-5">
            <h1 class="font-gilroy font-bold text-5xl">Profile Page</h1>
            <ul class="flex gap-x-5">
                <li><a href="{{ route('customer.profile.basics') }}" class="font-inter text-[24px] font-bold text-black transition-colors duration-200 hover:underline underline-offset-8 hover:text-cPrimary">Basics</a></li>
                <li><a href="{{ route('customer.profile.orders') }}" class="font-inter text-[24px] font-bold text-black transition-colors duration-200 hover:underline underline-offset-8 hover:text-cPrimary">Order</a></li>
                <li><a href="{{ route('customer.profile.reviews') }}" class="font-inter text-[24px] font-bold text-cPrimary underline underline-offset-8 transition-colors duration-200 hover:text-purple-700">Reviews</a></li>
            </ul>
        </div>
        <div class="flex flex-col">
            <a class="flex gap-x-[18px] py-3 border-b border-cGrey w-full hover:bg-cAccent hover:bg-opacity-10 p-3 rounded-md cursor-pointer">
                <flex class="flex flex-col gap-y-4 w-full">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col gap-y-2">
                            <h4 class="font-gilroy font-bold text-lg">EchoPoint Productions</h4>
                            <ul class="flex flex-row gap-x-2">
                                <li>@include('svgs.star')</li>
                                <li>@include('svgs.star')</li>
                                <li>@include('svgs.star')</li>
                                <li>@include('svgs.star')</li>
                                <li>@include('svgs.star')</li>
                            </ul>
                        </div>
                        <h4 class="font-gilroy font-bold text-base text-cDarkGrey">September 4, 2024</h4>
                    </div>
                    <h4 class="text-inter text-sm text-cDarkGrey">I like the quality of the cloth. Also the sewing</h4>
                    <div class="flex flex-row gap-x-3"> <!-- if naa pic -->
                        <div class="flex flex-row gap-x-2.5 bg-[#D69FFB]/20 p-4 rounded-lg w-[80px] h-[80px]">
                            <!-- Your content here -->
                        </div>
                        <div class="flex flex-row gap-x-2.5 bg-[#D69FFB]/20 p-4 rounded-lg w-[80px] h-[80px]">
                            <!-- Your content here -->
                        </div>
                    </div>
                </flex>
            </a>
        </div>
    </div>
    @include('layout.footer')
</body>

</html>