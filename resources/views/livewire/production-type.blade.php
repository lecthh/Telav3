<div>
    <ul class="flex gap-x-6">
        @foreach($productionTypes as $productionType)
        <li
            class="flex flex-col gap-y-4 p-6 rounded-lg bg-cGrey items-center justify-center transition ease-in-out hover:shadow-lg hover:animate-fade-in-up cursor-pointer
            {{ $selectedProductionType === $productionType->id ? 'border-2 border-purple-500' : 'border-gray-300' }}"
            wire:click="selectProductionType({{ $productionType->id }})">
            <img class="" src="{{ asset($productionType->img) }}" alt="">
            <h5 class="font-inter text-xl">{{ $productionType->name }}</h5>
        </li>
        @endforeach
    </ul>

    <div class="mt-[60px] flex gap-x-[12px]">
        <button wire:click="back" class="flex bg-[#9CA3AF] bg-opacity-20 text-opacity-50 rounded-xl text-black gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-gray-600">
            Back
        </button>
        <button wire:click="submit" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
            Continue
        </button>
    </div>
</div>