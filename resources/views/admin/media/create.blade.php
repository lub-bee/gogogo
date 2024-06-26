<x-admin-layout>
    <div class='section'>
        <h1>Media upload</h1>
    </div>

    {{-- nav --}}
    <div class='section'>
        <a href="{{route('media.index')}}" class="btn">Back</a>
    </div>

    {{-- form --}}
    <div class='section'>
        <div class='block-container p-4'>
            <form method="POST" action="{{route('media.store')}}" enctype="multipart/form-data">
                @csrf

                {{-- file --}}
                <div class="info">
                    <div>Picture</div>
                    {{--TODO--}}
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('picture')" class="mb-2" />
                        <input type="file" name="picture"/>
                    </div>
                </div>

                {{-- legend --}}
                <div class="info">
                    <div>Legend</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('legend')" class="mb-2" />
                        <textarea name="legend" class="form-input" class="w-full">{{old("legend")}}</textarea>
                    </div>
                </div>

                {{-- event --}}
                <div class="info">
                    <div>Event</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('event_id')" class="mb-2" />
                        <select name="event_id" class="w-full form-input">
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">{{ $event->name }}</option>
                            @endforeach
                        </select>
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

</x-admin-layout>
