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
                        <h1 class="font-gilroy font-bold text-xl text-black">Finalize Order - Order No.{{$order->order_id}}</h1>
                        <div class="flex gap-x-10">
                            <div class="flex flex-col">
                                <div class="flex w-full">
                                    <div class="w-[10px] bg-cPrimary"></div>
                                    <div class="flex flex-col bg-white rounded-tr-lg p-5 border-t border-r borer-l w-full">
                                        <div class="flex gap-x-6">
                                            <div class="flex gap-x-2 px-3 rounded-lg bg-cPrimary bg-opacity-20 items-center justify-center w-[45px] h-[50px]">@include('svgs.calendar')</div>
                                            <div class="flex flex-col gap-y-2">
                                                <h4 class="font-inter font-bold text-base">Date Requested</h4>
                                                <h4 class="font-inter text-base">{{ $order->created_at->format('F j, Y') }}</h4>
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
                                                <h4 class="font-inter text-base">{{$order->user->name}}</h4>
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
                                                <h4 class="font-inter text-base">{{$order->user->email}}</h4>
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
                                                <h4 class="font-inter text-base">{{$order->apparelType->name}}</h4>
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
                                                <h4 class="font-inter text-base">{{ $order->is_bulk_order ? 'Bulk' : 'Single' }}</h4>
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
                                                <h4 class="font-inter text-base">{{ $order->is_customized ? 'Personalized' : 'Standard' }}</h4>
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
                                                <h4 class="font-inter text-base">{{ $order->designer->user->name }}</h4>
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
                                                @foreach ($order->imagesWithStatusTwo as $image)
                                                <div class="w-[245px] h-[186px]">
                                                    <img src="{{ asset('storage/' . $image->image) }}" alt="Order Image" class="w-full h-full object-cover">
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex p-3 bg-cPrimary font-gilroy font-bold text-white text-base rounded-t-lg">
                                        <h3>Job Order</h3>
                                    </div>
                                    <div class="flex flex-col gap-y-3 p-3 bg-white border rounded-b-lg">
                                        @if($customizationDetails)
                                        <div class="flex p-3 gap-x-[18px] w-full rounded-lg cursor-pointer items-center justify-start">
                                            <div class="flex w-8 h-8 bg-cAccent bg-opacity-20 rounded-lg justify-center items-center">
                                                @include('svgs.download')
                                            </div>
                                            <h3 class="font-gilroy font-bold text-base">0981_JobOrder.xlsx</h3>
                                        </div>
                                        @else
                                        <h3 class="font-gilroy font-bold text-base text-red-500">Confirmation Form Not Filled Up</h3>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex p-3 bg-cPrimary font-gilroy font-bold text-white text-base rounded-t-lg">
                                        <h3>Actions</h3>
                                    </div>
                                    <div class="flex flex-col gap-y-3 p-3 bg-white border rounded-b-lg">
                                        <div class="flex justify-start gap-x-3">
                                            <button type="" class="flex bg-red-500 rounded-xl text-white text-base gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-red-600">
                                                Cancel Order
                                            </button>
                                            <button type="" class="flex bg-cPrimary rounded-xl text-white text-base gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                                                Next Stage
                                            </button>
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