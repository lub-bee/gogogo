<x-admin-layout>

    <div class='section'>
        <div class="text-right">
            <a href="{{ route('media.create')}}" class="btn">Upload</a>
        </div>
    </div>

    <div class='section'>
        <div class='block-container p-4'>
            @if($pending_medias->count() > 0)
            <div class='title-1 mb-4'>
                Media Pending Validation
            </div>
            @endif
            <div class='grid grid-cols-4 gap-4'>
                @forelse ($pending_medias as $media)
                    <x-media.admin-media-card :media="$media"/>
                @empty
                @endforelse
            </div>

            @if($valid_medias->count() > 0)
            <div class='title-1 mt-4'>
                Media
            </div>
            @endif
            <div class='grid grid-cols-4 gap-4'>
                @forelse ($valid_medias as $media)
                    <x-media.admin-media-card :media="$media"/>
                @empty
                @endforelse
            </div>
        </div>
    </div>

</x-admin-layout>
