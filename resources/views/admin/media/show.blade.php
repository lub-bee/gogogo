<x-admin-layout>

    <div class='section flex justify-between'>
        <a href="{{ route('media.index')}}" class="btn">Back</a>
        <a href="{{ route('media.edit', $media->id)}}" class="btn">Edit</a>
        <a href="{{ route('media.destroy', $media->id) }}" class="btn">Delete</a>
    </div>

    <div class="section">
        <div class="block-container p-4">

            <div class='flex justify-center'>
                <x-media-card :media="$media"/>
            </div>

            <div class='info'>
                <div>Preview</div>
                <div>
                    <img
                        src="{{ asset("pictures/" . $media->path) }}"/>
                </div>
            </div>
            <div class='info'>
                <div>Description (English)</div>
                <div>
                    {{$media->description_en}}
                </div>
            </div>

            <div class='info'>
                <div>Description (Japanese)</div>
                <div>
                    {{$media->description_ja}}
                </div>
            </div>

        <div class="info">
            <div>Author</div>
            <div><a href='{{route("user.show", $media->user->id)}}' class="hover:text-blue-500 cursor-pointer">{{ $media->user->name}}</a></div>
            <div>Last Update</div>
            <div>{{$media->updated_at}}</div>
        </div>
    </div>
    </div>

</x-admin-layout>
