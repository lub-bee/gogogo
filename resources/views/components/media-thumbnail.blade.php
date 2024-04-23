@props(['media'])
<a
    class='rounded-lg relative inline-block overflow-hidden w-[100px] h-[100px] hover:scale-105 transition-all bg-cover'
    style="background-image: url('{{ asset($media->pathUrl)}}')"
    href="{{ route('media.show', $media->id) }}"
></a>
