<div class="flex items-center border-b border-gray-200 mb-6">
    <a href="{{ route('partner.designer.orders') }}"
        class="px-6 py-3 font-inter font-medium text-base {{ Request::routeIs('partner.designer.orders') ? 'text-cGreen border-b-2 border-cGreen -mb-px font-bold' : 'text-gray-700 hover:text-cGreen hover:border-b-2 hover:border-cGreen/50 transition duration-150' }}">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>Assigned Orders</span>
        </div>
    </a>
    <a href="{{ route('partner.designer.complete') }}"
        class="px-6 py-3 font-inter font-medium text-base {{ Request::routeIs('partner.designer.complete') ? 'text-cGreen border-b-2 border-cGreen -mb-px font-bold' : 'text-gray-700 hover:text-cGreen hover:border-b-2 hover:border-cGreen/50 transition duration-150' }}">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Completed Orders</span>
        </div>
    </a>
</div>