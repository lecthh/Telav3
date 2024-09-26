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
                        <h1 class="font-gilroy font-bold text-xl text-black">Complete - Order No.0981</h1>
                        <div class="flex gap-x-10">
                            <div class="flex flex-col">
                                <div class="flex w-full">
                                    <div class="w-[10px] bg-cPrimary"></div>
                                    <div class="flex flex-col bg-white rounded-tr-lg p-5 border-t border-r borer-l">
                                        <div class="flex gap-x-6">
                                            <div class="flex gap-x-2 px-3 rounded-lg bg-cPrimary bg-opacity-20 items-center justify-center w-[45px] h-[50px]">@include('svgs.calendar')</div>
                                            <div class="flex flex-col gap-y-2">
                                                <h4 class="font-inter font-bold text-base">Date Requested</h4>
                                                <h4 class="font-inter text-base">September 12, 2024</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-[10px] bg-cPrimary"></div>
                                    <div class="flex flex-col bg-white p-5 border-t border-r borer-l w-full">
                                        <div class="flex gap-x-6">
                                            <div class="flex gap-x-2 px-3 py-3 rounded-lg bg-cPrimary bg-opacity-20 items-center justify-center w-[45px] h-[50px]">@include('svgs.user-single')</div>
                                            <div class="flex flex-col gap-y-2">
                                                <h4 class="font-inter font-bold text-base">Customer Name</h4>
                                                <h4 class="font-inter text-base">Alexis Paramore</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-[10px] bg-cPrimary"></div>
                                    <div class="flex flex-col bg-white p-5 border-t border-r borer-l w-full">
                                        <div class="flex gap-x-6">
                                            <div class="flex gap-x-2 px-3 py-3 rounded-lg bg-cPrimary bg-opacity-20 items-center justify-center w-[45px] h-[50px]">@include('svgs.email')</div>
                                            <div class="flex flex-col gap-y-2">
                                                <h4 class="font-inter font-bold text-base">Email</h4>
                                                <h4 class="font-inter text-base">alexis@gmail.com</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-[10px] bg-cPrimary"></div>
                                    <div class="flex flex-col bg-white p-5 border-t border-r borer-l w-full">
                                        <div class="flex gap-x-6">
                                            <div class="flex gap-x-2 px-3 py-3 rounded-lg bg-cPrimary bg-opacity-20 items-center justify-center w-[45px] h-[50px]">@include('svgs.shirt')</div>
                                            <div class="flex flex-col gap-y-2">
                                                <h4 class="font-inter font-bold text-base">Apparel Type</h4>
                                                <h4 class="font-inter text-base">T-shirt</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-[10px] bg-cPrimary"></div>
                                    <div class="flex flex-col bg-white p-5 border-t border-r border-l w-full">
                                        <div class="flex gap-x-6">
                                            <div class="flex gap-x-2 px-3 py-3 rounded-lg bg-cPrimary bg-opacity-20 items-center justify-center w-[45px] h-[50px]">@include('svgs.receipt-check')</div>
                                            <div class="flex flex-col gap-y-2">
                                                <h4 class="font-inter font-bold text-base">Order Type</h4>
                                                <h4 class="font-inter text-base">Bulk</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-[10px] bg-cPrimary"></div>
                                    <div class="flex flex-col bg-white p-5 border-t border-r border-l w-full">
                                        <div class="flex gap-x-6">
                                            <div class="flex gap-x-2 px-3 py-3 rounded-lg bg-cPrimary bg-opacity-20 items-center justify-center w-[45px] h-[50px]">@include('svgs.paintbrush')</div>
                                            <div class="flex flex-col gap-y-2">
                                                <h4 class="font-inter font-bold text-base">Customization</h4>
                                                <h4 class="font-inter text-base">Personalized</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-[10px] bg-cPrimary"></div>
                                    <div class="flex flex-col bg-white p-5 border rounded-br-lg w-full">
                                        <div class="flex gap-x-6">
                                            <div class="flex gap-x-2 px-3 py-3 rounded-lg bg-cPrimary bg-opacity-20 items-center justify-center w-[45px] h-[50px]">@include('svgs.paintbrush-1')</div>
                                            <div class="flex flex-col gap-y-2">
                                                <h4 class="font-inter font-bold text-base">Designer</h4>
                                                <h4 class="font-inter text-base">Jane Doe</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-y-8 w-full">
                                <div class="flex flex-col">
                                    <div class="flex p-3 bg-cPrimary font-gilroy font-bold text-white text-base rounded-t-lg">
                                        <h3>Final Design</h3>
                                    </div>
                                    <div class="flex gap-x-3 p-3 bg-white border rounded-b-lg">
                                        <div class="flex flex-col gap-y-3">
                                            <div class="flex gap-x-3 w-full">
                                                <div class="w-[300px] h-[300px] bg-cAccent"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex p-3 bg-cPrimary font-gilroy font-bold text-white text-base rounded-t-lg">
                                        <h3>Job Order</h3>
                                    </div>
                                    <div class="flex flex-col gap-y-3 p-3 bg-white border rounded-b-lg">
                                        <div class="flex p-3 gap-x-[18px] w-full rounded-lg cursor-pointer items-center justify-start">
                                            <div class="flex w-8 h-8 bg-cAccent bg-opacity-20 rounded-lg justify-center items-center">@include('svgs.download')</div>
                                            <h3 class="font-gilroy font-bold text-base">0981_JobOrder.xlsx</h3>
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