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
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css " rel="stylesheet" />
    @vite('resources/css/app.css')
</head>
@include('layout.nav')

<body>
    <div class="relative flex gap-x-20 p-[200px] bg-white/10 items-center justify-between animate-fade-in">
        <div class="flex flex-col gap-y-6">
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl w-[447px]">Bring Your Apparel Designs to Life</h1>
                <p class="font-inter text-base w-[447px]">Custom printing made easy – from design to production, we've
                    got you covered</p>
            </div>
            <div class="flex gap-x-6">
                @livewire('button', ['text' => 'Start Your Custom Order'])
                @livewire('button', ['style' => 'tertiary', 'text' => 'Browse Production Services'])
            </div>
        </div>
        <div class="flex flex-col gap-y-6">
            <img class="absolute h-[632px] left-2/4 top-[1px]" src="{{ asset('imgs/hero/hero1.png') }}" alt="">
        </div>
    </div>
    <div class="flex gap-x-20 p-[200px] bg-cSecondary items-center animate-fade-in-up">
        <div class="flex flex-col gap-y-6 p-10 bg-white rounded-2xl">
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl w-[447px]">Bring Your Apparel Designs to Life</h1>
                <p class="font-inter text-base w-[447px]">Custom printing made easy – from design to production, we've
                    got you covered</p>
            </div>
        </div>
    </div>
</body>
@include('layout.footer')
@include('customer.modal-login')
</html>