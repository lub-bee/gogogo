<x-admin-layout>
    <div class='section'>
        <a href="{{ route('event.index')}}" class="btn">Back</a>
    </div>
    <div class='section'>
        <div class='block-container p-4'>

            <form method="POST" action="{{route('event.store')}}">

                @csrf

                <div class="info">
                    <div>Event Name (Required) </div>
                    <div>
                        <input type="text" name="name" value='{{old("name")}}'>
                        @error("name")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Start (Required) </div>
                    <div>
                        <input type="datetime-local" name="start_at" value='{{old("start_at")}}' class="w-full">
                        @error("start_at")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                    <div>End</div>
                    <div>
                        <input type="datetime-local" name="end_at" value='{{old("end_at")}}' class="w-full">
                        @error("end_at")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Cost</div>
                    <div>
                        <input type="text" name="cost" value='{{old("cost")}}'>
                        @error("cost")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Description (English)</div>
                    <div class="col-span-3">
                        <textarea name="description_en" class="w-full">{{old("description_en")}}</textarea>
                        @error("description_en")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="info">
                    <div>Description (Japanese)</div>
                    <div class="col-span-3">
                        <textarea name="description_ja" class="w-full">{{old("description_ja")}}</textarea>
                        @error("description_ja")
                        <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Status</div>
                    <div class="col-span-3">
                        <div>
                            <label>
                                <input
                                type="radio"
                                name="status"
                                value="draft" {{old('published_at', null) == null ? 'checked' : '' }}
                                >
                                Draft (Only visible from the administator)
                            </label>
                        </div>
                        <div>
                            <label>
                                <input
                                type="radio"
                                name="status"
                                value="published" {{old('published_at', null) !== null ? 'checked' : '' }}
                                >
                                Published
                                <input
                                type="date"
                                name="published_at"
                                value='{{old("published_at", Carbon\Carbon::now()->format("Y-m-d"))}}'
                                >
                                <x-input-error :messages="$errors->get('published_at')" class="mb-2" />
                            </label>
                        </div>
                    </div>
                </div>

                <div class="info">
                    <div>Topic</div>
                    <div>
                        <select name="topic_id">
                            <option value="">-</option>
                            @foreach ($topics as $topic)
                                <option value="{{$topic->id}}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                        @error("topic_id")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Location</div>
                    TODO - pluck - dropdown

                </div>

                <div class="flex justify-center gap-4 mt-5">
                    <a class="btn" href="{{ route('event.index') }}">
                        CANCEL
                    </a>
                    <button type="submit" class="btn btn-main">
                        SAVE
                    </button>
                </div>
            </form>

            <div class="uppercase">SomeText in it WITH RANDoM CAp</div>
        </div>
    </div>
</x-admin-layout>
