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
    @vite('resources/css/select.css')
</head>
@include('layout.nav')

<body class="flex flex-col h-screen justify-between">
    <div class="font-inter bg-white flex flex-col px-[200px] py-[60px] gap-y-[40px]">
        <div class="flex flex-col gap-y-6">
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl">Partnered Production Companies</h1>
                <p class="text-gray-600 max-w-3xl">Find the perfect production partner for your custom apparel needs. Filter by apparel type, production method, and price to narrow down your options.</p>
            </div>
        </div>
        <div class="flex flex-col gap-y-6 animate-fade-in">
            @livewire('production-companies-component')
        </div>
    </div>
    @livewireScripts
</body>

@include('layout.footer')
</html>