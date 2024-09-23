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
    <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px]">
        <div class="flex flex-col gap-y-[50px] px-[50px] py-[60px]">
            <a href="">@include('svgs.check')</a>
            <div class="flex flex-col gap-y-10">
                <div class="flex flex-col gap-y-3">
                    <h2 class="font-gilroy font-bold text-3xl">Thanks for your payment</h2>
                    <h2 class="font-inter text-lg">Your request has been received.</h2>
                </div>
                <hr class="border-t-1 border-cSecondary w-full my-4">
                <div class="flex flex-col gap-y-3">
                    <div class="flex flex-row justify-between">
                        <h2 class="font-inter text-lg">Order Number:</h2>
                        <h2 class="font-inter font-bold text-lg">3941 PHP</h2>  
                    </div>
                    <div class="flex flex-row justify-between">
                        <h2 class="font-inter text-lg">Request Date:</h2>
                        <h2 class="font-inter font-bold text-lg">September 13, 2024</h2>  
                    </div>                    
                </div>
                <h3 class="font-inter text-lg">Please wait while we prepare your draft— it will be sent to you shortly for review.</h3>
            </div>
            <div class="flex flex-col gap-y-2.5 py-3.5 items-center">
                @livewire('button', ['text' => 'Confirm'])
            </div>
        </div>
    </div>
</body>


</html>


