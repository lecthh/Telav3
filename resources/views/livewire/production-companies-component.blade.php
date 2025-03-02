<div>
    <div class="flex flex-col gap-y-6">
        @foreach($productionCompanies->chunk(5) as $chunk)
        <div class="flex gap-x-4 justify-start">
            @foreach($chunk as $productionCompany)
            <div
                class="flex flex-col gap-y-4 p-4 rounded-md bg-[#F4F4F4] cursor-pointer transition ease-in-out hover:shadow-lg hover:animate-fade-in-up {{ $selectedProductionCompany === $productionCompany->id ? 'border-2 border-purple-500' : 'border-gray-300' }}"
                wire:click="selectProductionCompany({{ $productionCompany->id }})">
                <div class="flex flex-col gap-y-3 w-[168px]">
                    <img class="object-cover" src="{{ asset($productionCompany->company_logo) }}" alt="{{ $productionCompany->company_name }}">
                </div>
                <div class="flex flex-col gap-y-2 w-[168px]">
                    <div class="flex flex-col gap-y-1 font-gilroy">
                        <h5 class="text-cDarkGrey text-base font-bold">{{ $productionCompany->company_name }}</h5>
                    </div>
                    <a class="font-inter text-cPrimary text-base hover:underline cursor-pointer">Visit Page</a>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>