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
                        <div>
                            <h3 class="text-black text-2xl font-bold">
                                @if(isset($pricingData[$productionCompany->id]['base_price']))
                                    {{ number_format($pricingData[$productionCompany->id]['base_price'], 2) }} PHP
                                @else
                                    Price unavailable
                                @endif
                            </h3>
                            <p class="text-sm text-gray-500">starting price</p>
                        </div>
                        @if(isset($pricingData[$productionCompany->id]['bulk_price']) && $pricingData[$productionCompany->id]['bulk_price'] > 0)
                            <p class="text-sm text-cPrimary">Bulk orders from {{ number_format($pricingData[$productionCompany->id]['bulk_price'], 2) }} PHP</p>
                        @endif
                    </div>
                    <a class="font-inter text-cPrimary text-base hover:underline cursor-pointer">Visit Page</a>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>

    <div class="mt-[60px] flex gap-x-[12px]">
        <button wire:click="back" class="flex bg-[#9CA3AF] bg-opacity-20 text-opacity-50 rounded-xl text-black gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-gray-600">
            Back
        </button>
        <button wire:click="submit" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]" {{ $selectedProductionCompany ? '' : 'disabled' }}>
            Continue
        </button>
    </div>
</div>