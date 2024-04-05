@props(['media'])
<div class='rounded-lg relative inline-block overflow-hidden max-w-[100px] hover:max-w-[200px] transition-all'>
    <img
        src="{{ asset("pictures/" . $media->path) }}"
        alt="{{ $media->path }}"
    />
</div>
