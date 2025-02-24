<!doctype html>
<html>
@include('layout.nav')

<body>
    <div class="relative flex gap-x-20 p-[200px] bg-white/10 items-center justify-between animate-fade-in">
        <div class="flex flex-col gap-y-6">
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl w-[447px]">Bring Your Apparel Designs to Life</h1>
                <p class="font-inter text-base w-[447px]">Custom printing made easy – from design to production, we've
                    got you covered</p>
            </div>
            <div class="flex gap-x-6">
                <a wire:navigate href="{{ route('customer.place-order.select-apparel') }}" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">Start Your Custom Order</a>
                @livewire('button', ['style' => 'tertiary', 'text' => 'Browse Production Services'])
            </div>
        </div>
        <div class="flex flex-col gap-y-6">
            <img class="absolute h-[632px] left-2/4 top-[1px]" src="{{ asset('imgs/hero/hero1.png') }}" alt="">
        </div>
    </div>
    <div class="flex gap-x-20 p-[200px] bg-cSecondary items-center animate-fade-in-up">
        <div class="flex flex-col gap-y-6 p-10 bg-white rounded-2xl">
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl w-[447px]">Bring Your Apparel Designs to Life</h1>
                <p class="font-inter text-base w-[447px]">Custom printing made easy – from design to production, we've
                    got you covered</p>
            </div>
        </div>
    </div>

</body>
@include('layout.footer')

</html>