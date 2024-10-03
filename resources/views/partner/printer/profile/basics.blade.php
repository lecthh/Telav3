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
                            <a href="{{ route('partner.printer.profile.basics') }}"><li class="font-inter font-bold text-xl py-3 border-b text-cPrimary border-cPrimary hover:text-cPrimary hover:border-cPrimary cursor-pointer">
                                Basics
                            </li></a>
                            <a href="{{ route('partner.printer.profile.pricing') }}"><li class="font-inter font-bold text-xl py-3 text-black hover:text-cPrimary hover:border-b hover:border-cPrimary cursor-pointer transition ease-in-out">
                                Pricing
                            </li></a>
                        </ul>
                        <div class="flex flex-col gap-y-6">
                            <div class="flex flex-col gap-y-4 w-[600px]">
                                <h4 class="font-gilroy font-bold">Company Name</h4>
                                <input type="text" class="px-5 py-4 border-black rounded-md">
                            </div>
                            <div class="flex flex-col gap-y-4 w-[600px]">
                                <h4 class="font-gilroy font-bold">Email</h4>
                                <input type="email" class="px-5 py-4 border-black rounded-md">
                            </div>
                            <div class="flex flex-col gap-y-4 w-[600px]">
                                <h4 class="font-gilroy font-bold">Mobile No.</h4>
                                <input type="number" class="px-5 py-4 border-black rounded-md">
                            </div>
                            <div class="flex flex-col gap-y-4 w-[600px]">
                                <h4 class="font-gilroy font-bold">Address</h4>
                                <input type="text" class="px-5 py-4 border-black rounded-md">
                            </div>
                        </div>
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