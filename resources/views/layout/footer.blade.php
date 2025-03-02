<footer class="flex gap-x-[10px] px-[100px] py-6 bg-cNot-black text-white justify-start">
    <div class="flex flex-col gap-y-[10px] text-sm">
        <h1 class="font-inter font-bold">Site Links</h1>
        <ul class="flex gap-x-6">
            <li class=""><a wire:navigate href="{{ route('home') }}">Home</a></li>
            <li class=""><a wire:navigate href="{{ route('customer.place-order.select-apparel') }}">Start Your Custom Order</a></li>
            <li class=""><a href="{{ route('production.services') }}">Browse Production Services</a></li>
            <li class=""><a wire:navigate href="{{ route('partner-registration') }}">Become a Partner</a></li>
            @guest
            <li class=""><a href="{{ route('login') }}">Business Hub</a></li>
            @endguest
        </ul>
    </div>
</footer>