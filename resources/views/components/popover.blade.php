<div x-data="{ show: false }" class="relative inline-block" @mouseenter="show = true" @mouseleave="show = false" x-cloak wire:ignore>
    <!-- Trigger Slot -->
    <div>
        {{ $trigger }}
    </div>
    <!-- Popover Content with Down-to-Up Animation -->
    <div x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform translate-y-2 opacity-0"
        x-transition:enter-end="transform translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform translate-y-0 opacity-100"
        x-transition:leave-end="transform translate-y-2 opacity-0"
        class="popover absolute bottom-full left-1/2 transform w-auto -translate-x-1/2 mb-2 px-2 py-1 bg-gray-100 font-medium text-black text-sm text-center rounded shadow border border-gray-200">
        {{ $slot }}
    </div>
</div>