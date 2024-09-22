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

<body>
    @include('layout.nav')
    <div class="flex flex-row">
        <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px] w-full">

            <div class="flex flex-col gap-y-5">
                <div class="flex flex-col gap-y-3">
                    <h1 class="font-gilroy font-bold text-5xl">Profile Page</h1>
                </div>
                <div class="flex flex-row gap-x-5 ">
                    <div class="flex flex-row gap-x-[60px] py-3">
                        <h1 class="font-inter font-bold text-2xl">Basics</h1>
                    </div>
                    <div class="flex flex-row gap-x-[60px] py-3">
                        <h1 class="font-inter font-bold text-2xl">Orders</h1>
                    </div>
                    <div class="flex flex-row gap-x-[60px] py-3">
                        <h1 class="font-inter font-bold text-2xl  text-cPrimary">Reviews</h1>
                    </div>                                
                </div>                    
            </div>

            <div class="flex flex-col">
                <div class="flex flex-row gap-x-[18px]">
                    <div class="flex flex-col gap-y-4 flex-grow">
                        <div class="flex flex-row items-start justify-between">
                            <div class="flex flex-col gap-y-2">
                                <div class="flex flex-col">
                                    <h2 class="font-gilroy font-bold text-lg">EchoPoint Productions</h2>
                                </div>
                                <div class="flex flex-row gap-x-2">
                                    <a href="">@include('svgs.star')</a>
                                    <a href="">@include('svgs.star')</a>
                                    <a href="">@include('svgs.star')</a>
                                    <a href="">@include('svgs.star')</a>
                                    <a href="">@include('svgs.star')</a>
                                </div>
                            </div>
                            <h2 class="font-gilroy font-bold text-base text-gray-500">September 13, 2024</h2>
                        </div>
                        <h2 class="font-inter text-sm text-gray-500">I like the quality of the cloth. Also, the sewing.</h2>
                        <div class="flex flex-row gap-x-3">
                            <div class="flex flex-row gap-x-2.5 bg-[#D69FFB]/20 p-4 rounded-lg w-[80px] h-[80px]">
                                <!-- Your content here -->
                            </div>
                            <div class="flex flex-row gap-x-2.5 bg-[#D69FFB]/20 p-4 rounded-lg w-[80px] h-[80px]">
                                <!-- Your content here -->
                            </div>                            
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="flex flex-row gap-x-[18px]">
                    <div class="flex flex-col gap-y-4 w-full flex-grow">
                        <div class="flex flex-row items-start justify-between">
                            <div class="flex flex-col gap-y-2">
                                <div class="flex flex-col">
                                    <h2 class="font-gilroy font-bold text-lg">EchoPoint Productions</h2>
                                </div>
                                <div class="flex flex-row gap-x-2">
                                    <a href="">@include('svgs.star')</a>
                                    <a href="">@include('svgs.star')</a>
                                    <a href="">@include('svgs.star')</a>
                                    <a href="">@include('svgs.star')</a>
                                    <a href="">@include('svgs.star')</a>
                                </div>
                            </div>
                            <h2 class="font-gilroy font-bold text-base text-gray-500">September 13, 2024</h2>
                        </div>
                        <h2 class="font-inter text-sm text-gray-500">I like the quality of the cloth. Also, the sewing.</h2>
                        <hr>
                    </div>
                </div>                

            </div>

        </div>

    </div>
</body>


</html>