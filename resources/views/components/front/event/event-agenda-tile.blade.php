@props(["date", "title", "slug", "icon" => "fas fa-book"])

<a class='flex gap-8 group' href="{{ route('front.event.show', $slug) }}">
    <div class='font-bold tracking-widest'>
        {{ $date }}
    </div>
    <div class=''>
        <i class="{{ $icon }} fa-fw"></i>
    </div>
    <div class='-tracking-[0.08em] font-light group-hover:tracking-tight transition-all text-nowrap'>
        {{ $title }}
    </div>
</a>
