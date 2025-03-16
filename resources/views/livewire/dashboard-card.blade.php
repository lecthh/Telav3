<a
    href="{{ $route ? route($route) : '' }}"
    class="flex flex-col p-5 bg-white drop-shadow-sm rounded-lg text-base justify-between w-full h-[113px] border border-cGrey transition ease-in-out delay-800 hover:drop-shadow-lg hover:border-cPrimary transform hover:scale-105">
    <div class="flex gap-x-3 items-center">
        <div class="bg-purple-100 p-2 rounded-full">
            @include($svg)
        </div>
        <h5 class="text-gray-700">{{ $heading }}</h5>
        <div class="ml-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    <h3 class="font-gilroy font-bold text-xl text-black">{{ $value }}</h3>
</a>