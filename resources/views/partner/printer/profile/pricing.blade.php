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

<body class="flex flex-col h-full justify-between">
    <div class="flex flex-col h-full">
        <div class="flex p-1 bg-cPrimary font-gilroy font-bold text-white text-sm justify-center">Production Hub</div>
        <div class="flex h-full">
            @include('layout.printer')
            <div class="flex flex-col gap-y-10 p-14 bg-[#F9F9F9] h-full w-full animate-fade-in">
                <div class="flex flex-col gap-y-1">
                    <h2 class="font-gilroy font-bold text-3xl text-black">Account</h2>
                </div>
                <div class="flex flex-col gap-y-6 p-5 bg-white drop-shadow-md rounded-md border">
                    <div class="flex flex-col gap-y-10">
                        <ul class="flex gap-x-5">
                            <a href="{{ route('partner.printer.profile.basics') }}">
                                <li class="font-inter font-bold text-xl py-3 hover:text-cPrimary hover:border-b hover:border-cPrimary cursor-pointer transition ease-in-out">
                                    Basics
                                </li>
                            </a>
                            <a href="{{ route('partner.printer.profile.pricing') }}">
                                <li class="font-inter font-bold text-xl py-3 text-cPrimary border-b border-cPrimary hover:text-cPrimary hover:border-cPrimary cursor-pointer">
                                    Pricing
                                </li>
                            </a>
                        </ul>
                        <table class="table-auto min-w-full overflow-hidden rounded-lg animate-fade-in">
                            <thead class="border drop-shadow-sm">
                                <tr class="bg-cPrimary font-bold text-base text-white">
                                    <th class="px-5 py-[14px] text-start rounded-tl-lg">
                                        <input type="checkbox" id="select_all" name="select_all" value="" class="cart-checkbox border border-black w-4 h-4 p-1 py-1 rounded checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary">
                                    </th>
                                    <th class="px-5 py-[14px] text-start">Apparel Type</th>
                                    <th class="px-5 py-[14px] text-start">Production Type</th>
                                    <th class="px-5 py-[14px] text-start">Base Price</th>
                                    <th class="px-5 py-[14px] text-start">Bulk Price</th>
                                </tr>
                            </thead>
                            <tbody class="border drop-shadow-sm">
                            @foreach ($pricingRecords as $record)
                                <tr class="odd:bg-gray-100 even:bg-white hover:bg-cAccent hover:bg-opacity-10 cursor-pointer">
                                    <td class="px-5 py-[14px]"><input type="checkbox"></td>
                                    <td class="px-5 py-[14px]">{{ $record->apparelType->name }}</td>
                                    <td class="px-5 py-[14px]">{{ $record->productionType->name }}</td>
                                    <td class="px-5 py-[14px]">{{ $record->base_price }}</td>
                                    <td class="px-5 py-[14px]">{{ $record->bulk_price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-start">
                        <button type="submit" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>