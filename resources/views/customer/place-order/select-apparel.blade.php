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

<x-blocked-banner-wrapper />

<body class="flex flex-col h-screen justify-between">
    @include('layout.nav')
    <div class="font-inter bg-white flex flex-col px-[200px] py-[100px] gap-y-[60px] animate-fade-in">
        <div class="flex flex-col gap-y-10">
            @include('customer.place-order.steps', ['currentStep' => $currentStep])
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl w-[447px]">Choose an Apparel</h1>
                <p class="font-inter text-base w-[447px]">Start by picking your favorite type and style of apparel. Whether it's a t-shirt, hoodie, or jersey, we've got plenty of options to suit your needs!</p>
            </div>
        </div>
        @livewire('apparel-type')
    </div>
    @include('layout.footer')
</body>

</html>