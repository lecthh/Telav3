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
    <div class="flex flex-col h-full">
        <div class="flex p-1 bg-cPrimary font-gilroy font-bold text-white text-sm justify-center">Production Hub</div>
        <div class="flex h-full">
            @include('layout.printer')
            <div class="flex flex-col gap-y-10 p-14 bg-[#F9F9F9] w-full">
                <div class="flex flex-col gap-y-1">
                    <h2 class="font-gilroy font-bold text-3xl text-black">Hello, EchoPoint Productions</h2>
                    <h4 class="font-inter text-base">Here's what's going on today.</h4>
                </div>
                <div class="flex flex-col gap-y-5">
                    <div class="flex flex-col gap-y-[10px]">
                        <h1 class="font-gilroy font-bold text-2xl">Orders</h1>
                        @include('partner.printer.order-nav')
                    </div>
                    <table class="table-auto min-w-full overflow-hidden rounded-lg animate-fade-in">
                        <thead class="border drop-shadow-sm">
                            <tr class="bg-cPrimary font-bold text-base text-white">
                                <th class="px-5 py-[14px] text-start rounded-tl-lg">
                                    <input type="checkbox" id="select_all" name="select_all" value="" class="cart-checkbox border border-black w-4 h-4 p-1 py-1 rounded checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary">
                                </th>
                                <th class="px-5 py-[14px] text-start">Date</th>
                                <th class="px-5 py-[14px] text-start">Order no.</th>
                                <th class="px-5 py-[14px] text-start">Customer</th>
                                <th class="px-5 py-[14px] text-start">Email</th>
                                <th class="px-5 py-[14px] text-start">Remaining Payment</th>
                                <th class="px-5 py-[14px] text-start">Total Payment</th>
                            </tr>
                        </thead>
                        <tbody class="border drop-shadow-sm">
                            <tr class="odd:bg-gray-100 even:bg-white hover:bg-cAccent hover:bg-opacity-10 cursor-pointer">
                                <td class="px-5 py-[14px]"><input type="checkbox" class="cart-checkbox ..."></td>
                                <td class="px-5 py-[14px]">9/11/1999</td>
                                <td class="px-5 py-[14px]">0493</td>
                                <td class="px-5 py-[14px]">Alexis Paramore</td>
                                <td class="px-5 py-[14px]">alexis@gmail.com</td>
                                <td class="px-5 py-[14px]">100 PHP</td>
                                <td class="px-5 py-[14px]">5000 PHP</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>