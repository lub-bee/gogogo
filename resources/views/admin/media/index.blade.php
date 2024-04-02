<x-admin-layout>

    <div class='section'>
        <div class="text-right">
            <a href="{{ route('media.create')}}" class="btn">Upload</a>
        </div>
    </div>

    <div class='section'>
        <div class='block-container'>
            <table class="table my-5">
                <tr>
                    <th>PREVIEW</th>
                    <th>Description (English)</th>
                    <th>Description (Japanese)</th>
                </tr>
                @foreach ($medias as $media)
                    <tr>
                        <td>
                            <a href="{{ route('media.show', $media->id)}}" class="btn">
                                Preview thumbnail {{--TODO--}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('media.show', $media->id)}}">
                                {{$media->description_en}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('media.show', $media->id)}}">
                                {{$media->description_ja}}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

</x-admin-layout>
