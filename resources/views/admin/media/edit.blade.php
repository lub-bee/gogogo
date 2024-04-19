<x-admin-layout>
    <div class='section'>
        <a href="{{route('media.index')}}" class="btn">Back</a>
    </div>

    <div class='section'>
        <div class='block-container p-4'>

            <div class='title-1'>
                Media edition
            </div>

            <form method="POST" action="{{route('media.update', $media->id)}}">
                @csrf
                @method('PUT')
                <input type="hidden" name="media_id" value="{{$media->id}}"/>

                <div class="info">
                    <div>Preview</div>
                    <div>
                        <img
                            src="{{ $media->pathUrl }}"/>
                    </div>
                </div>

                <div class="info">
                    <div>Legend</div>
                    <div class="col-span-3">
                        <textarea name="description_en" class="w-full">{{old("description_en")}}</textarea>
                        @error("description_en")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>
                {{-- <div class="info">
                    <div>Description (Japanese)</div>
                    <div class="col-span-3">
                        <textarea name="description_ja" class="w-full">{{old("description_ja")}}</textarea>
                        @error("description_ja")
                        <div>{{$message}}</div>
                        @enderror
                    </div>
                </div> --}}

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

    {{-- <x-editor-loader/> --}}
</x-admin-layout>
