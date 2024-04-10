@props(['media'])
<div class='rounded-lg relative group/media-card inline-block overflow-hidden' x-data='{ open: false }' @click="open = !open">
    <img
        {{-- src="{{ asset("pictures/" . $media->path) }}" --}}
        src="{{ $media->pathUrl }}"
        alt="{{ $media->path }}"
        class="max-h-[80vh] max-w-screen"
    />


    <div class='absolute top-0 left-0 right-0 p-4 flex gap-4 bg-white/80 opacity-0 group-hover/media-card:opacity-100 transition-all' :class="{ 'opacity-100': open }">
        <a href="{{ route('top.user', $media->user->id) }}" class='flex-1 link'>
            event
        </a>
        <a href="{{ route('top.user', $media->user->id) }}" class='link'>
            {{ $media->user->name }}
        </a>
    </div>

    @if ($media->description_en || $media->description_ja)
        <div class='absolute bottom-0 left-0 right-0 flex flex-col p-2 px-4 gap-2 bg-white/80 opacity-0 group-hover/media-card:opacity-100 transition-all' :class="{ 'opacity-100': open }">
            @if ($media->description_en)
                <div>
                    {{ $media->description_en }}
                </div>
            @endif

            @if ($media->description_ja)
                <div>
                    {{ $media->description_ja }}
                </div>
            @endif
        </div>
    @endif
</div>
