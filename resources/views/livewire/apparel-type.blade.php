<div>
    <ul class="flex gap-x-6">
        @foreach($apparelTypes as $apparelType)
        <li
            class="flex flex-col gap-y-4 p-6 rounded-lg bg-cGrey items-center justify-center transition ease-in-out hover:shadow-lg hover:animate-fade-in-up cursor-pointer
            {{ $selectedApparelType === $apparelType->id ? 'border-2 border-purple-500' : 'border-gray-300' }}"
            wire:click="selectApparelType({{ $apparelType->id }})">
            <img class="" src="{{ asset($apparelType->img) }}" alt="">
            <h5 class="font-inter text-xl">{{ $apparelType->name }}</h5>
        </li>
        @endforeach
    </ul>

    @php
    $isBlocked = auth()->check() && auth()->user()->isBlocked();
    @endphp

    <div class="mt-[60px]">
        <button
            wire:click="submit"
            class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]"
            @disabled($isBlocked)>
            Continue
        </button>
    </div>

</div>