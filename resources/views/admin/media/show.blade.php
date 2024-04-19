<x-admin-layout>

    <div class='section flex justify-between'>
        <a href="{{ route('media.index')}}" class="btn">Back</a>
        <a href="{{ route('media.edit', $media->id)}}" class="btn">Edit</a>
        {{-- <a href="{{ route('media.destroy', $media->id) }}" class="btn">Delete</a> --}}
    </div>

    @if(!$media->validated)
    <div class='section'>
        <div class="block-container p-4 flex gap-4 items-center">
            <div class='flex-1 text-4xl'>
                <i class="fa-solid fa-circle-exclamation text-amber-500"></i> Pending validation
            </div>

            {{-- delete form --}}
            <form class="" action="{{ route('media.destroy', request()->query()) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="media_id" value="{{$media->id}}" />
                <button type="submit" class="flex-1 btn btn-danger">Refuse</button>
            </form>

            {{-- validate form --}}
            <form class="" action="{{ route('media.validate', request()->query()) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="media_id" value="{{$media->id}}" />

                <button type="submit" class="flex-1 btn btn-success">Authorize</button>
            </form>
        </div>
    </div>
    @endif

    <div class="section">
        <div class="block-container p-4">
            <div class=''>
                <div class='title-1'>
                    Media Preview
                </div>
            </div>
            <div class='flex justify-center'>
                <x-media-card :media="$media"/>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="block-container p-4">
            <div class='title-1'>
                Media Details
            </div>

            <div class='info'>
                <div>Thumbnail</div>
                <div>
                    <img src="{{ $media->pathUrl }}"/>
                </div>
            </div>
            <div class='info'>
                <div>Legend</div>
                <div>
                    {{$media->description_en}}
                </div>
            </div>

            {{-- <div class='info'>
                <div>Description (Japanese)</div>
                <div>
                    {{$media->description_ja}}
                </div>
            </div> --}}

            <div class="info">
                <div>Author</div>
                <div><a href='{{route("user.show", $media->user->id)}}' class="hover:text-blue-500 cursor-pointer">{{ $media->user->name}}</a></div>
                <div>Last Update</div>
                <div>{{$media->updated_at}}</div>
            </div>
        </div>
    </div>

    @if($media->event)
    <div class="section">
        <div class="block-container p-4">
            <div class='title-1'>
                Related Event
            </div>
            <x-event.event-detail :event="$media->event"/>
        </div>
    </div>
    @endif

</x-admin-layout>
