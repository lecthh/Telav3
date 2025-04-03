<div x-data="{ open: @entangle($attributes->wire('model')).live }"
    x-show="open"
    x-cloak
    class="fixed inset-0 flex items-center justify-center z-50">

    <div @click="open = false" wire:loading.class="pointer-events-none"
        class="absolute inset-0 bg-gray-900 opacity-50"></div>

    <!-- Modal Container -->
    <div @click.stop class="bg-white rounded-lg shadow-lg overflow-hidden z-10 w-11/12 md:w-1/2">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold">{{ $title }}</h3>
            <button @click="open = false" wire:loading.class="pointer-events-none"
                class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <!-- Modal Content -->
        <div class="p-4">
            {{ $slot }}
        </div>
    </div>
</div>