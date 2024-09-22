<div class="flex flex-col gap-y-6">
    @foreach($productionCompanies->chunk(5) as $chunk)
        <div class="flex gap-x-4 justify-start">
            @foreach($chunk as $productionCompany)
                <div class="flex flex-col gap-y-4 p-4 rounded-md bg-[#F4F4F4]">
                    <div class="flex flex-col gap-y-3 p-6 w-[168px]">
                        <img class="object-cover" src="{{ asset($productionCompany->company_logo) }}" alt="{{ $productionCompany->company_name }}">
                    </div>
                    <div class="flex flex-col gap-y-2 w-[168px]">
                        <div class="flex flex-col gap-y-1 font-gilroy">
                            <h5 class="text-cDarkGrey text-base font-bold">{{ $productionCompany->company_name }}</h5>
                            <h3 class="text-black text-2xl font-bold">4996 PHP</h3>
                        </div>
                        <a class="font-inter text-cPrimary text-base hover:underline cursor-pointer">Visit Page</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>