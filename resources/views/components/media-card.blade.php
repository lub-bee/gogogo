@props(['media'])
<div class='rounded-lg relative group/media-card inline-block overflow-hidden'>
    <img
        src="{{ asset("pictures/" . $media->path) }}"
        alt="{{ $media->path }}"
    />
    <div class='absolute bottom-0 left-0 right-0 top-0 flex flex-col justify-end divide-y'>
        <div class='bg-white opacity-0 group-hover/media-card:opacity-70 p-4 transition-all'>
            {{ $media->description_en }}
        </div>
        <div class='bg-white opacity-0 group-hover/media-card:opacity-70 p-4 transition-all'>
            {{ $media->description_ja }}
        </div>
    </div>
</div>
