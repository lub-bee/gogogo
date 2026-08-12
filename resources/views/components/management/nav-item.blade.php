@props(['route', 'icon', 'label'])

@php
    $active = request()->routeIs($route) || request()->routeIs($route . '.*');
    $classes = $active
        ? 'flex items-center px-3 py-2 rounded text-sm font-bold uppercase tracking-widest bg-slate-700 text-white'
        : 'flex items-center px-3 py-2 rounded text-sm font-bold uppercase tracking-widest text-slate-300 hover:bg-slate-700 hover:text-white transition-colors';
@endphp

<a href="{{ route($route) }}" class="{{ $classes }}">
    <i class="fa-solid {{ $icon }} fa-fw mr-2 text-xs"></i>{{ $label }}
</a>
