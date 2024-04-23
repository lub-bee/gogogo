<x-admin-layout>
    <div class='section'>
        <a href="{{route('media.index')}}" class="btn">Back</a>
    </div>

    <div class='section'>
        <div class='block-container p-4'>

            <div class='title-1'>
                Media upload
            </div>

            <form method="POST" action="{{route('media.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="info">
                    <div>Picture</div>
                    {{--TODO--}}
                    <div class="">
                        <input type="file" name="picture"/>
                        @error("picture")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    {{-- <div>Description (English)</div> --}}
                    <div>Legend</div>
                    <div class="col-span-3">
                        <textarea name="legend" class="form-input" class="w-full">{{old("legend")}}</textarea>
                        @error("legend")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Event</div>
                    <div class="col-span-3">
                        <select name="event_id" class="w-full form-input">
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">{{ $event->name }}</option>
                            @endforeach
                        </select>
                        @error("event_id")
                        <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-5">
                    <a class="btn" href="{{ route('media.index') }}">
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
