@php
    $styles = [
        'primary' => 'flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]',
        'secondary' => 'flex bg-white border text-cPrimary border-cPrimary rounded-xl gap-y-3 px-6 py-3 hover:shadow-md hover:bg-gray-500 disabled:opacity-30 active:bg-gray-500',
        'tertiary' => 'flex bg-white rounded-xl text-cPrimary gap-y-3 px-6 py-3 hover:shadow-md hover:bg-gray-500 disabled:opacity-30 active:bg-gray-500',
        'greyed' => 'flex bg-[#9CA3AF] rounded-xl opacity-20 text-black gap-y-3 px-6 py-3 hover:shadow-md disabled:opacity-30 active:bg-gray-600'
    ];
@endphp
<button class="{{ $styles[$style] ?? $styles['primary'] }}">
    @if($icon)
        @include('svgs.' . $icon)
    @endif
    {{ $text ?? 'Click Me' }}
</button>
