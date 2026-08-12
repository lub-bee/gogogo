{{--
    Section header band — the giant overflow-clipped uppercase label.
    Usage: <x-front.section-header bg="bg-slate-700" text="text-white">Agenda</x-front.section-header>
--}}
@props([
    'bg' => 'bg-slate-700',
    'text' => 'text-white',
])

<header class="section-header {{ $bg }} {{ $text }} flex-none">
    {{ $slot }}
</header>
