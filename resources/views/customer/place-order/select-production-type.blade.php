<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
</head>
@include('layout.nav')

<body class="flex flex-col h-screen justify-between">
    <div class="font-inter bg-white flex flex-col px-[200px] py-[100px] gap-y-[60px]">
        <div class="flex flex-col gap-y-10">
            <ul class="flex gap-x-4 font-gilroy font-bold text-2xl">
                <li><a href="" class="flex flex-col w-16 h-16 p-6 rounded-full bg-cGrey text-cDarkGrey items-center justify-center">1</a></li>
                <li><a href="" class="flex flex-col w-16 h-16 p-6 rounded-full bg-cGreen items-center justify-center">2</a></li>
                <li><a href="" class="flex flex-col w-16 h-16 p-6 rounded-full bg-cGrey text-cDarkGrey items-center justify-center">3</a></li>
                <li><a href="" class="flex flex-col w-16 h-16 p-6 rounded-full bg-cGrey text-cDarkGrey items-center justify-center">4</a></li>
                <li><a href="" class="flex flex-col w-16 h-16 p-6 rounded-full bg-cGrey text-cDarkGrey items-center justify-center">5</a></li>
            </ul>
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl w-[447px]">Choose Production Type</h1>
                <p class="font-inter text-base w-[447px]">Next, decide how you want your design to come to life. You can choose from methods like screen printing or embroidery—whatever best fits your vision!</p>
            </div>
        </div>
        @livewire('production-type')
        <div class="flex justify-start">
            @livewire('button', ['text' => 'Continue'])
        </div>
    </div>
    @include('layout.footer')
</body>

</html>