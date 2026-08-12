{{--
    Diagonal "See all" navigation band.
    Color pairs per section:
    - agenda/media: blue (#b7d7fc) → yellow-100, text turns white on hover
    - topic: yellow-100 → blue (#b7d7fc)
    - location: pink-200 → yellow-100

    Usage: <x-front.diagonal-nav href="/agenda" color="blue" />
--}}
@props([
    'href' => '#',
    'label' => 'See all',
    'color' => 'blue', // blue | topic | pink
])

@php
    $config = match($color) {
        'blue' => [
            'band'      => 'bg-gogo-blue',
            'hover'     => 'group-hover:bg-yellow-100',
            'mobileBg'  => 'bg-gogo-blue',
            'textHover' => true,  // text turns white on hover
        ],
        'topic' => [
            'band'      => 'bg-gogo-yellow',
            'hover'     => 'group-hover:bg-gogo-blue',
            'mobileBg'  => 'bg-gogo-yellow md:bg-transparent',
            'textHover' => false,
        ],
        'pink' => [
            'band'      => 'bg-pink-200',
            'hover'     => 'group-hover:bg-yellow-100',
            'mobileBg'  => 'bg-pink-200',
            'textHover' => false,
        ],
        default => [
            'band'      => 'bg-gogo-blue',
            'hover'     => 'group-hover:bg-yellow-100',
            'mobileBg'  => 'bg-gogo-blue',
            'textHover' => true,
        ],
    };
@endphp

<nav class="flex-none flex justify-end text-nav-sm md:text-nav-lg uppercase cursor-pointer text-[#111725]">
    <a href="{{ $href }}"
       class="w-full md:w-[45%] md:block relative group pr-4 md:pr-0 text-center {{ $config['mobileBg'] }}">
        {{-- Desktop rotating slab --}}
        <div class="hidden md:block absolute top-0 left-0 h-full w-full {{ $config['band'] }} {{ $config['hover'] }} group-hover:scale-x-[10%] transform group-hover:rotate-[30deg] transition-all"></div>
        {{-- Label --}}
        <div class="relative z-10 px-8 group-hover:scale-x-105 transition-all whitespace-nowrap {{ $config['textHover'] ? 'group-hover:text-white' : '' }}">
            {{ $label }}
        </div>
    </a>
</nav>
