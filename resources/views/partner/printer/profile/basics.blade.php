<html>

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
                    <form action="{{ route('partner.printer.profile.update') }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-y-10">
                            <ul class="flex gap-x-5">
                                <a href="{{ route('partner.printer.profile.basics') }}">
                                    <li class="font-inter font-bold text-xl py-3 border-b text-cPrimary border-cPrimary hover:text-cPrimary hover:border-cPrimary cursor-pointer">
                                        Basics
                                    </li>
                                </a>
                                <a href="{{ route('partner.printer.profile.pricing') }}">
                                    <li class="font-inter font-bold text-xl py-3 text-black hover:text-cPrimary hover:border-b hover:border-cPrimary cursor-pointer transition ease-in-out">
                                        Pricing
                                    </li>
                                </a>
                            </ul>
                            <div class="flex flex-col gap-y-6">
                                <div class="flex flex-col gap-y-4 w-[600px]">
                                    <h4 class="font-gilroy font-bold">Company Name</h4>
                                    <input type="text" name="company_name" class="px-5 py-4 border-black rounded-md" value="{{ old('company_name', $productionCompany->company_name) }}">
                                </div>
                                <div class="flex flex-col gap-y-4 w-[600px]">
                                    <h4 class="font-gilroy font-bold">Email</h4>
                                    <input type="email" name="email" class="px-5 py-4 border-black rounded-md" value="{{ old('email', $productionCompany->email) }}">
                                </div>
                                <div class="flex flex-col gap-y-4 w-[600px]">
                                    <h4 class="font-gilroy font-bold">Mobile No.</h4>
                                    <input type="number" name="phone" class="px-5 py-4 border-black rounded-md" value="{{ old('phone', $productionCompany->phone) }}">
                                </div>
                                <div class="flex flex-col gap-y-4 w-[600px]">
                                    <h4 class="font-gilroy font-bold">Address</h4>
                                    <input type="text" name="address" class="px-5 py-4 border-black rounded-md" value="{{ old('address', $productionCompany->address) }}">
                                </div>
                            </div>
                        </div>
                        <br>
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