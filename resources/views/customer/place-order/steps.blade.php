<ul class="flex gap-x-4 font-gilroy font-bold text-2xl">
    <li>
        <a wire:navigate href="{{ route('customer.place-order.select-apparel') }}" class="flex flex-col w-16 h-16 p-6 rounded-full items-center justify-center {{ Route::is('customer.place-order.select-apparel') ? 'bg-cGreen text-black' : 'bg-cGrey text-cDarkGrey' }}">
            1
        </a>
    </li>
    <li>
        <a wire:navigate href="{{ route('customer.place-order.select-production-type') }}" class="flex flex-col w-16 h-16 p-6 rounded-full items-center justify-center {{ Route::is('customer.place-order.select-production-type') ? 'bg-cGreen text-black' : 'bg-cGrey text-cDarkGrey' }}">
            2
        </a>
    </li>
    <li>
        <a wire:navigate href="{{ route('customer.place-order.select-production-company') }}" class="flex flex-col w-16 h-16 p-6 rounded-full items-center justify-center {{ Route::is('customer.place-order.select-production-company') ? 'bg-cGreen text-black' : 'bg-cGrey text-cDarkGrey' }}">
            3
        </a>
    </li>
    <li>
        <a wire:navigate href="{{ route('customer.place-order.customization') }}" class="flex flex-col w-16 h-16 p-6 rounded-full items-center justify-center {{ Route::is('customer.place-order.customization') ? 'bg-cGreen text-black' : 'bg-cGrey text-cDarkGrey' }}">
            4
        </a>
    </li>
    <li>
        <a wire:navigate href="{{ route('customer.place-order.review') }}" class="flex flex-col w-16 h-16 p-6 rounded-full items-center justify-center {{ Route::is('customer.place-order.review') ? 'bg-cGreen text-black' : 'bg-cGrey text-cDarkGrey' }}">
            5
        </a>
    </li>
</ul>