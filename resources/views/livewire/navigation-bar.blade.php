<nav class="flex px-[100px] py-3.5 justify-between items-center bg-white text-[18px] font-inter text-cNot-black border border-b border-[#424242]/20">
    <div class="flex gap-x-6 items-center">
        <a href="">@include('svgs.logo')</a>
        <a href="">Home</a>
        <a href="">Start Your Custom Order</a>
    </div>
    <div class="flex gap-x-6 items-center">
        <div class="flex gap-x-3">
            <a href="">@include('svgs.inbox-empty')</a>
            <a href="">@include('svgs.bell')</a>
            <a href="">@include('svgs.basket')</a>
        </div>
        <!-- if user logged in, change to user name -->
        <a href="">Login/Sign Up</a>
        @livewire('button', ['text' => 'Order Now'])
    </div>
</nav>
