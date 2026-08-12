{{--
    Location venue row — icon + title with gap/size hover animation.
    Icons: fa-mug-hot (coffee), fa-utensils (restaurant), fa-book (study), fa-location-dot (other)

    Usage: <x-front.location-row icon="fa-mug-hot" name="The Mall" :count="14" href="/location/the-mall" />
--}}
@props([
    'icon' => 'fa-location-dot',
    'name' => 'Location',
    'count' => 0,
    'href' => '#',
])

<a href="{{ $href }}" class="loc-line group flex flex-col items-start py-2">
    <div class="flex loc-row items-center">
        <i class="fa-solid {{ $icon }} fa-fw loc-icon"></i>
        <div class="text-[2rem] sm:text-[3rem] lg:text-[4.5rem] leading-[2rem] sm:leading-[3rem] lg:leading-[4.5rem] font-bold uppercase tracking-poster group-hover:tracking-tight loc-title">
            {{ $name }}
        </div>
    </div>
    <div class="flex gap-3 items-baseline mt-1 loc-sub">
        <span class="text-xs sm:text-sm uppercase tracking-widest text-slate-500 font-bold">{{ $count }} {{ Str::plural('event', $count) }}</span>
        <span class="text-xs sm:text-sm text-slate-400">{{ $count }}件</span>
    </div>
</a>
