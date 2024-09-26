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
        <div class="flex p-1 bg-cPrimary font-gilroy font-bold text-white text-sm justify-center">Production Hub</div>
        <div class="flex">
            @include('layout.printer')
            <div class="flex flex-col gap-y-10 p-14 bg-[#F9F9F9] w-full">
                <div class="flex flex-col gap-y-5">
                    <div class="flex flex-col gap-y-10">
                        <h1 class="font-gilroy font-bold text-2xl">Orders</h1>
                        @include('partner.printer.order-nav')
                        <h1 class="font-gilroy font-bold text-xl text-black">Pending Request - Order No.0981</h1>
                        <div class="flex gap-x-10">
                            <div class="flex flex-col">
                                <div class="flex">
                                    <div class="w-[10px] bg-cPrimary"></div>
                                    <div class="flex flex-col bg-white rounded-tr-lg p-5 border-t border-r borer-l">
                                        <div class="flex gap-x-6">
                                            <div class="flex gap-x-2 px-3 rounded-lg bg-cPrimary bg-opacity-20 items-center justify-center">@include('svgs.calendar')</div>
                                            <div class="flex flex-col gap-y-2">
                                                <h4 class="font-inter font-bold text-base">Date Requested</h4>
                                                <h4 class="font-inter text-base">September 12, 2024</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-[10px] bg-cPrimary"></div>
                                    <div class="flex flex-col bg-white p-5 border-t border-r borer-l">
                                        <div class="flex gap-x-6">
                                            <div class="flex gap-x-2 px-3 py-3 rounded-lg bg-cPrimary bg-opacity-20">@include('svgs.calendar')</div>
                                            <div class="flex flex-col gap-y-2">
                                                <h4 class="font-inter font-bold text-base">Date Requested</h4>
                                                <h4 class="font-inter text-base">September 12, 2024</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>