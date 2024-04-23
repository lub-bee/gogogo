@props(['media'])
<div>
    <div class='rounded relative overflow-hidden group/media'>
        <img
            src="{{ asset($media->pathUrl) }}"
            alt="{{ $media->pathUrl }}"
            class="w-full h-full object-cover"
        />


        @if($media->validated)
        <div class='absolute top-2 right-2 group-hover/media:opacity-100 opacity-0 transition-all'>
            <form class="flex-1 flex" action="{{ route('media.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="media_id" value="{{$media->id}}" />
                <button type="submit" class="btn-compact-danger p-1 px-2 bg-gray-100">
                    <i class='fa-solid fa-trash-alt'></i>
                </button>
            </form>
        </div>
        @endif
        <div class='absolute bottom-2 left-0 right-0 flex justify-center group-hover/media:opacity-100 opacity-0 transition-all'>
            <a href="{{ route('media.show', $media->id) }}" class="btn-compact-main p-2 px-4 bg-gray-100">View</a>
        </div>
    </div>
    @if(!$media->validated)
        <div class=' left-0 right-0 bg-gray-100'>
            <div class='font-bold text-xs p-2 text-amber-500'>
                <i class="fa-solid fa-circle-exclamation"></i> Pending validation
            </div>
            <div class='flex gap-2  p-2 pt-0'>
                {{-- delete form --}}
                <form class="flex-1 flex" action="{{ route('media.destroy', request()->query()) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="media_id" value="{{$media->id}}" />
                    <button type="submit" class="flex-1 btn-compact-danger">Refuse</button>
                </form>

                {{-- validate form --}}
                <form class="flex-1 flex" action="{{ route('media.validate', request()->query()) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="media_id" value="{{$media->id}}" />

                    <button type="submit" class="flex-1 btn-compact-success">Authorize</button>
                </form>
            </div>
        </div>
    @endif
</div>
