<a href="" class="flex flex-col p-5 bg-white drop-shadow-sm rounded-lg text-base justify-between w-full h-[113px] border border-cGrey transition ease-in-out delay-800 hover:drop-shadow-lg">
    <div class="flex gap-x-3 items-center">
        @include($svg)
        <h5>{{ $heading }}</h5>
    </div>
    <h3 class="font-gilroy font-bold text-xl text-black">{{ $value }}</h3>
</a>