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

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

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
                        <form action="{{ route('partner.printer.profile.pricing.update') }}" method="POST">
                            @csrf
                            <table>
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Apparel Type</th>
                                        <th>Production Type</th>
                                        <th>Base Price</th>
                                        <th>Bulk Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pricingRecords as $record)
                                        <tr class="odd:bg-gray-100 even:bg-white hover:bg-cAccent hover:bg-opacity-10 cursor-pointer">
                                            <td class="px-5 py-[14px]"><input type="checkbox" name="selected_records[]" value="{{ $record->id }}"></td>
                                            <td class="px-5 py-[14px]">{{ $record->apparelType->name }}</td>
                                            <td class="px-5 py-[14px]">{{ $record->productionType->name }}</td>
                                            <td class="px-5 py-[14px]"><input type="text" name="base_price[{{ $record->id }}]" value="{{ $record->base_price }}"></td>
                                            <td class="px-5 py-[14px]"><input type="text" name="bulk_price[{{ $record->id }}]" value="{{ $record->bulk_price }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="flex justify-start">
                                <button type="submit" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">Save</button>
                            </div>
                        </form>                   
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>