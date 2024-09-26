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

<body class="flex flex-col justify-between h-screen">
    <div class="flex flex-col h-full">
        @include('layout.nav')
        <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px] bg-white">
            <div class="flex flex-col gap-y-3">
                <h3 class="font-gilroy font-bold text-5xl">Order Confirmation</h3>
                <h5 class="font-inter text-base">Order No. 0981</h5>
            </div>
            @livewire('order-jersey-bulk-customized')
            <div class="flex justify-start gap-x-3">
                <button type="button" onclick="Livewire.dispatch('openModal', { component: 'modal-login-signup' })" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                    Confirm
                </button>
            </div>
        </div>
    </div>
    @include('layout.footer')
</body>

</html>