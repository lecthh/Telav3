<ul class="flex gap-x-4 font-gilroy font-bold text-2xl animate-fade-in-up">
    <!-- Step 1 -->
    <li>
        <a wire:navigate
            href="{{ route('customer.place-order.select-apparel') }}"
            class="flex flex-col w-16 h-16 p-6 rounded-full items-center justify-center 
                  {{ $currentStep >= 1 ? (Route::is('customer.place-order.select-apparel') ? 'bg-cGreen text-black' : 'bg-cGrey text-cDarkGrey') : 'bg-cGrey text-gray-400 cursor-not-allowed' }}"
            {{ $currentStep >= 1 ? '' : 'onclick="return false;"' }}>
            1
        </a>
    </li>

    <!-- Step 2 -->
    <li>
        <a wire:navigate
            href="{{ $currentStep >= 2 ? route('customer.place-order.select-production-type', ['apparel' => $apparel]) : '#' }}"
            class="flex flex-col w-16 h-16 p-6 rounded-full items-center justify-center 
                  {{ $currentStep === 2 ? 'bg-cGreen text-black' : ($currentStep > 2 ? 'bg-cGrey text-cDarkGrey' : 'bg-cGrey text-gray-400 cursor-not-allowed') }}"
            {{ $currentStep >= 2 ? '' : 'onclick="return false;"' }}>
            2
        </a>
    </li>

    <!-- Step 3 -->
    <li>
        <a wire:navigate
            href="{{ $currentStep >= 3 ? route('customer.place-order.select-production-company', ['apparel' => $apparel, 'productionType' => $productionType]) : '#' }}"
            class="flex flex-col w-16 h-16 p-6 rounded-full items-center justify-center 
                  {{ $currentStep >= 3 ? (Route::is('customer.place-order.select-production-company') ? 'bg-cGreen text-black' : 'bg-cGrey text-cDarkGrey') : 'bg-cGrey text-gray-400 cursor-not-allowed' }}"
            {{ $currentStep >= 3 ? '' : 'onclick="return false;"' }}>
            3
        </a>
    </li>

    <!-- Step 4 -->
    <li>
        <a wire:navigate
            href="{{ $currentStep >= 4 ? route('customer.place-order.customization', ['apparel' => $apparel, 'productionType' => $productionType, 'company' => $company]) : '#' }}"
            class="flex flex-col w-16 h-16 p-6 rounded-full items-center justify-center 
                  {{ $currentStep >= 4 ? (Route::is('customer.place-order.customization') ? 'bg-cGreen text-black' : 'bg-cGrey text-cDarkGrey') : 'bg-cGrey text-gray-400 cursor-not-allowed' }}"
            {{ $currentStep >= 4 ? '' : 'onclick="return false;"' }}>
            4
        </a>
    </li>

    <!-- Step 5 -->
    <li>
        <a wire:navigate
            href="{{ $currentStep >= 5 ? route('customer.place-order.review', ['apparel' => $apparel, 'productionType' => $productionType, 'company' => $company]) : '#' }}"
            class="flex flex-col w-16 h-16 p-6 rounded-full items-center justify-center 
                  {{ $currentStep >= 5 ? (Route::is('customer.place-order.review') ? 'bg-cGreen text-black' : 'bg-cGrey text-cDarkGrey') : 'bg-cGrey text-gray-400 cursor-not-allowed' }}"
            {{ $currentStep >= 5 ? '' : 'onclick="return false;"' }}>
            5
        </a>
    </li>
</ul>