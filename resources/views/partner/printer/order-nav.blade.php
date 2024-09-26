<div class="flex gap-x-5">
    <ul>
        <a href="{{ route('partner.printer.orders') }}"
           class="flex gap-x-[60px] py-3 font-inter font-bold text-base {{ Request::routeIs('partner.printer.orders') ? 'text-cPrimary border-b border-cPrimary' : 'text-black' }} hover:border-cPrimary hover:text-cPrimary transition ease-in-out delay-100">
            <li>Pending Requests</li>
        </a>
    </ul>
    <ul>
        <a href="{{ route('partner.printer.design-in-progress') }}"
           class="flex gap-x-[60px] py-3 font-inter font-bold text-base {{ Request::routeIs('partner.printer.design-in-progress') ? 'text-cPrimary border-b border-cPrimary' : 'text-black' }} hover:border-cPrimary hover:text-cPrimary transition ease-in-out delay-100">
            <li>Design in Progress</li>
        </a>
    </ul>
    <ul>
        <a href="{{ route('partner.printer.finalize-order') }}"
           class="flex gap-x-[60px] py-3 font-inter font-bold text-base {{ Request::routeIs('partner.printer.finalize-order') ? 'text-cPrimary border-b border-cPrimary' : 'text-black' }} hover:border-cPrimary hover:text-cPrimary transition ease-in-out delay-100">
            <li>Finalize Order</li>
        </a>
    </ul>
    <ul>
        <a href="{{ route('partner.printer.awaiting-printing') }}"
           class="flex gap-x-[60px] py-3 font-inter font-bold text-base {{ Request::routeIs('partner.printer.awaiting-printing') ? 'text-cPrimary border-b border-cPrimary' : 'text-black' }} hover:border-cPrimary hover:text-cPrimary transition ease-in-out delay-100">
            <li>Awaiting Printing</li>
        </a>
    </ul>
    <ul>
        <a href="{{ route('partner.printer.printing-in-progress') }}"
           class="flex gap-x-[60px] py-3 font-inter font-bold text-base {{ Request::routeIs('partner.printer.printing-in-progress') ? 'text-cPrimary border-b border-cPrimary' : 'text-black' }} hover:border-cPrimary hover:text-cPrimary transition ease-in-out delay-100">
            <li>Printing in Progress</li>
        </a>
    </ul>
    <ul>
        <a href="{{ route('partner.printer.ready') }}"
           class="flex gap-x-[60px] py-3 font-inter font-bold text-base {{ Request::routeIs('partner.printer.ready') ? 'text-cPrimary border-b border-cPrimary' : 'text-black' }} hover:border-cPrimary hover:text-cPrimary transition ease-in-out delay-100">
            <li>Ready</li>
        </a>
    </ul>
    <ul>
        <a href="{{ route('partner.printer.completed') }}"
           class="flex gap-x-[60px] py-3 font-inter font-bold text-base {{ Request::routeIs('partner.printer.completed') ? 'text-cPrimary border-b border-cPrimary' : 'text-black' }} hover:border-cPrimary hover:text-cPrimary transition ease-in-out delay-100">
            <li>Completed</li>
        </a>
    </ul>
</div>