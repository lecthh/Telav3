<div class="flex overflow-x-auto border-b border-gray-200 mb-6">
    <nav class="flex space-x-1 w-full">
        @php
        $navItems = [
        ['route' => 'partner.printer.orders', 'label' => 'Pending Requests', 'icon' => 'svgs.shipping-box'],
        ['route' => 'partner.printer.design-in-progress', 'label' => 'Design in Progress', 'icon' => 'svgs.print-palette'],
        ['route' => 'partner.printer.finalize-order', 'label' => 'Finalize Order', 'icon' => 'svgs.receipt-check'],
        ['route' => 'partner.printer.awaiting-printing', 'label' => 'Awaiting Printing', 'icon' => 'svgs.square-clock'],
        ['route' => 'partner.printer.printing-in-progress', 'label' => 'Printing Progress', 'icon' => 'svgs.shredder-device'],
        ['route' => 'partner.printer.ready', 'label' => 'Ready', 'icon' => 'svgs.check-circle'],
        ['route' => 'partner.printer.completed', 'label' => 'Completed', 'icon' => 'svgs.award']
        ];
        @endphp

        @foreach($navItems as $item)
        <a href="{{ route($item['route']) }}" class="
                flex items-center space-x-2 px-4 py-3 
                {{ Request::routeIs($item['route']) ? 'text-cPrimary border-b-2 border-cPrimary' : 'text-gray-600 hover:text-cPrimary' }} 
                transition-colors duration-200 group
            ">
            <div class="{{ Request::routeIs($item['route']) ? 'text-cPrimary' : 'text-gray-400 group-hover:text-cPrimary' }} transition-colors duration-200">
                @include($item['icon'])
            </div>
            <span class="font-inter font-semibold text-base whitespace-nowrap">
                {{ $item['label'] }}
            </span>
        </a>
        @endforeach
    </nav>
</div>