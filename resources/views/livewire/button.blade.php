@php
    $styles = [
        'primary' => 'flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]',
        'secondary' => 'flex bg-white border text-cPrimary border-cPrimary rounded-xl gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md hover:bg-gray-500 disabled:opacity-30 active:bg-gray-500',
        'tertiary' => 'flex bg-white rounded-xl text-black gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:bg-gray-50 disabled:opacity-30 active:bg-gray-50',
        'greyed' => 'flex bg-[#9CA3AF] bg-opacity-20 text-opacity-50 rounded-xl text-black gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-gray-600',
        
        'secondary_black' => 'flex bg-white border text-black border-black rounded-xl gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md hover:bg-gray-50 disabled:opacity-30 active:bg-gray-500',

    ];
@endphp
<button class="{{ $styles[$style] ?? $styles['primary'] }} gap-x-3">
    @if($icon)
        @include('svgs.' . $icon)
    @endif
    {{ $text ?? 'Click Me' }}
</button>
