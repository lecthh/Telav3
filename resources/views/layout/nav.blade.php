<nav class="flex px-[100px] py-3.5 justify-between items-center bg-white text-[18px] font-inter text-cNot-black border border-b border-[#424242]/20">
    <div class="flex gap-x-6 items-center">
        <a wire:navigate href="{{ route('home') }}">@include('svgs.logo')</a>
        <a wire:navigate href="{{ route('home') }}">Home</a>
        <a wire:navigate href="{{ route('customer.place-order.select-apparel') }}">Start Your Custom Order</a>
    </div>
    <div class="flex gap-x-6 items-center" x-data="{ isOpen: false }">
        <div class="flex gap-x-3">
            <button href="">@include('svgs.inbox-empty')</button>
            <button href="" @click.prevent="isOpen = !isOpen">@include('svgs.bell')</button>
            <button href="">@include('svgs.basket')</button>
        </div>
        <button x-show="isOpen" @click.away="isOpen = false" class="absolute top-16 animate-fade-in" x-cloak>
            @livewire('modal-notification')
        </button>
        <!-- if user logged in, change to user name -->
        @if(Auth::check())
            <a wire:navigate href="{{ route('customer.profile.basics') }}">{{ Auth::user()->name }}</a>
        @else
            <button onclick="Livewire.dispatch('openModal', { component: 'modal-login' })" href="">Login/Sign Up</button>
        @endif
        <a wire:navigate href="{{ route('customer.place-order.select-apparel') }}" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">Order Now</a>
    </div>
</nav>
@livewire('wire-elements-modal')
