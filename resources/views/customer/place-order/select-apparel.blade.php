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
            @include('customer.place-order.steps')
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl w-[447px]">Choose an Apparel</h1>
                <p class="font-inter text-base w-[447px]">Start by picking your favorite type and style of apparel. Whether it's a t-shirt, hoodie, or jersey, we've got plenty of options to suit your needs!</p>
            </div>
        </div>
        @livewire('apparel-type')
        <div class="flex justify-start">
            @livewire('button', ['text' => 'Continue'])
        </div>
    </div>
    @include('layout.footer')
</body>

</html>