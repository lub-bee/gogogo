@props(["date", "title"])

<div class='flex gap-8 group'>
    <div class=''>
        {{ $date }}
    </div>
    <div class='-tracking-[0.08em] group-hover:tracking-tight transition-all'>
        {{ $title }}
    </div>
</div>
