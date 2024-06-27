@props(["date", "title", "slug"])

<a class='flex gap-8 group' href="{{ route('front.event.show', $slug) }}">
    <div class=''>
        {{ $date }}
    </div>
    <div class='-tracking-[0.08em] group-hover:tracking-tight transition-all text-nowrap'>
        {{ $title }}
    </div>
</a>
