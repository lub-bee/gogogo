<x-admin-layout>

    <div class='section'>
        <h1>Media edition</h1>
    </div>

    {{-- nav --}}
    <div class='section'>
        <a href="{{route('media.index')}}" class="btn">Back</a>
    </div>

    {{-- form --}}
    <div class='section'>
        <div class='block-container p-4'>

            <form method="POST" action="{{route('media.update', $media->id)}}">
                @csrf
                @method('PUT')
                <input type="hidden" name="media_id" value="{{$media->id}}"/>

                {{-- file --}}
                <div class="info">
                    <div>Preview</div>
                    <div>
                        <img src="{{ $media->pathUrl }}"/>
                    </div>
                </div>

                {{-- legend --}}
                <div class="info">
                    <div>Legend</div>
                    <div class="col-span-3">
                        <textarea name="legend" class="form-input">{{old("legend")}}</textarea>
                        @error("legend")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-5">
                    <a class="btn" href="{{ route('media.show', $media->id) }}">
                        CANCEL
                    </a>
                    <button type="submit" class="btn btn-main">
                        UPLOAD
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>
