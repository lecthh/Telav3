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
    @vite('resources/css/select.css')
    @vite('resources/css/app.css')
</head>
@include('layout.nav')

<body class="flex flex-col h-screen justify-between">
    <div class="font-inter bg-white flex flex-col px-[200px] py-[100px] gap-y-[60px]">
        <div class="flex flex-col gap-y-10">
            @include('customer.place-order.steps', ['currentStep' => $currentStep])
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl">Choose a Production Company</h1>
                <p class="font-inter text-base">Select a trusted production company to bring your custom apparel to life.</p>
            </div>
        </div>
        <div class="flex flex-col gap-y-6 animate-fade-in">
            <div class="flex justify-start">
                @livewire('include.base-price-filter')
            </div>
            <div class="flex gap-y-6">
                @livewire('production-company-card', ['apparel' => $apparel, 'productionType' => $productionType])
            </div>
        </div>
    </div>
</body>
@include('layout.footer')

</html>