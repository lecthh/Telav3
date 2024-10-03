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

<body class="flex flex-col h-screen justify-between">
    <div class="flex flex-col">
        <div class="flex p-1 bg-cGreen font-gilroy font-bold text-black text-sm justify-center">Designer Hub</div>
        <div class="flex h-screen">
            @include('layout.designer')
            <div class="flex flex-col gap-y-10 p-14 bg-[#F9F9F9] w-full animate-fade-in">
                <div class="flex flex-col gap-y-1">
                    <h2 class="font-gilroy font-bold text-3xl text-black">Hello, {{$productionCompany->user->name}}</h2>
                    <h4 class="font-inter text-base">Here's what's going on today.</h4>
                </div>
                <ul class="flex gap-x-5">
                    @livewire('dashboard-card', ['svg' => 'svgs.shipping-box', 'heading' => 'Assigned Orders', 'value' => $assignedOrdersCount])
                    @livewire('dashboard-card', ['svg' => 'svgs.shredder-device', 'heading' => 'Completed Orders', 'value' => $completedOrdersCount])
                </ul>
                <ul class="flex gap-x-5 justify-between">
                    <li class="flex flex-col p-5 bg-white drop-shadow-sm rounded-lg text-base justify-between w-full h-[113px] border border-cGrey">
                        <div class="flex gap-x-3 items-center">
                            <h5>Payouts</h5>
                        </div>
                        <h3 class="font-gilroy font-bold text-xl text-black">3</h3>
                    </li>
                </ul>
                <div class="flex flex-col gap-y-5">
                    <h3 class="flex font-gilroy font-bold text-lg text-black">Statistics</h3>
                    <li class="flex flex-col p-5 bg-white drop-shadow-sm rounded-lg text-base justify-between w-full h-[200px] border border-cGrey">
                    </li>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>