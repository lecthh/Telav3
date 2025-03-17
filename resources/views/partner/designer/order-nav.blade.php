<div class="flex gap-x-5">
    <ul>
        <a href="{{ route('partner.designer.orders') }}"
            class="flex gap-x-[60px] py-3 font-inter font-bold text-base {{ Request::routeIs('partner.designer.orders') ? 'text-cGreen border-b border-cGreen' : 'text-black' }} hover:border-cGreen hover:text-cGreen transition ease-in-out delay-100">
            <li>Assigned Orders</li>
        </a>
    </ul>
    <ul>
        <a href="{{ route('partner.designer.complete') }}"
            class="flex gap-x-[60px] py-3 font-inter font-bold text-base {{ Request::routeIs('partner.designer.complete') ? 'text-cGreen border-b border-cGreen' : 'text-black' }} hover:border-cGreen hover:text-cGreen transition ease-in-out delay-100">
            <li>Completed Orders</li>
        </a>
    </ul>
</div>