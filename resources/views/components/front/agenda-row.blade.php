{{--
    Agenda row — date + icon + title with tracking hover.
    Usage: <x-front.agenda-row day="22" icon="fa-book" title="Gogogo Friday" href="/event/gogogo" />
--}}
@props([
    'day' => '01',
    'icon' => 'fa-book',
    'title' => 'Event',
    'href' => '#',
    'muted' => false,
])

<a class="flex gap-8 group {{ $muted ? 'text-slate-500' : '' }}" href="{{ $href }}">
    <div class="font-bold tracking-widest whitespace-nowrap">{{ $day }}</div>
    <div><i class="fas {{ $icon }} fa-fw"></i></div>
    <div class="-tracking-[0.08em] font-light group-hover:tracking-tight transition-all whitespace-nowrap">{{ $title }}</div>
</a>
