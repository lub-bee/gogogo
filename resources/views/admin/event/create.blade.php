<x-admin-layout>

    <div class='section'>
        <h1>Event Create</h1>
    </div>

    {{-- nav --}}
    <div class='section'>
        <a href="{{ route('event.index')}}" class="btn">Back</a>
    </div>

    {{-- form --}}
    <div class='section'>
        <div class='block-container p-4'>

            <form method="POST" action="{{route('event.store')}}">

                @csrf

                {{-- event name --}}
                <div class="info">
                    <div>Event Name <x-required/></div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('name')" class="mb-2" />
                        <input type="text" name="name" class="form-input" value='{{old("name")}}'>
                    </div>
                </div>

                <div class="info">
                    {{-- event start --}}
                    <div>Start <x-required/></div>
                    <div>
                        <x-input-error :messages="$errors->get('start_at')" class="mb-2" />
                        <input type="datetime-local" name="start_at" value='{{old("start_at")}}' class="form-input">
                    </div>

                    {{-- event end --}}
                    <div>End</div>
                    <div>
                        <x-input-error :messages="$errors->get('end_at')" class="mb-2" />
                        <input type="datetime-local" name="end_at" value='{{old("end_at")}}' class="form-input">
                    </div>
                </div>

                {{-- event cost --}}
                <div class="info">
                    <div>Cost</div>
                    <div>
                        <x-input-error :messages="$errors->get('cost')" class="mb-2" />
                        <input type="text" name="cost" class="form-input" value='{{old("cost")}}'>
                    </div>
                </div>

                {{-- event description EN (editor) --}}
                <div class="info h-fit">
                    <div>Content (EN)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_en')" class="mb-2" />
                        <textarea id="description_en" name="description_en" class="hidden">{{old('description_en')}}</textarea>
                        <div id="editor_en" class="">{!! old('description_en') !!}</div>
                    </div>
                </div>

                {{-- event description JA (editor) --}}
                <div class="info h-fit">
                    <div>Description (Japanese)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_ja')" class="mb-2" />
                        <textarea id="description_ja" name="description_ja" class="hidden">{{old('description_ja')}}</textarea>
                        <div id="editor_ja" class="">{!! old('description_ja') !!}</div>
                    </div>
                </div>

                {{-- event status --}}
                <div class="info">
                    <div>Status</div>
                    <div class="col-span-3">
                        <div>
                            <label>
                                <input
                                    type="radio"
                                    name="status"
                                    value="draft" {{old('status', null) == null ? 'checked' : '' }}
                                >
                                Draft (Only visible from the administator)
                            </label>
                        </div>
                        <div>
                            <label>
                                <x-input-error :messages="$errors->get('published_at')" class="mb-2" />
                                <input
                                    type="radio"
                                    name="status"
                                    value="published" {{old('published_at', null) !== null ? 'checked' : '' }}
                                >
                                Published
                                <div class='inline-block'>
                                    <input
                                        type="date"
                                        name="published_at"
                                        class="form-input"
                                        value='{{old("published_at", Carbon\Carbon::now()->format("Y-m-d"))}}'
                                    >
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- event topic --}}
                <div class="info">
                    <div>Topic</div>
                    <div class="col-span-2">
                        <x-input-error :messages="$errors->get('topic_id')" class="mb-2" />
                        <select name="topic_id" class="form-input">
                            <option value="">-</option>
                            @foreach ($topics as $topic)
                                <option value="{{$topic->id}}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="info">
                    {{-- event location --}}
                    <div>Location</div>
                    <div class="col-span-2">
                        <x-input-error :messages="$errors->get('location_id')" class="mb-2" />
                        <select name="location_id" class="form-input">
                            <option value="">-</option>
                            @foreach ($locations as $location)
                            <option value="{{$location->id}}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>

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
        </div>
    </div>

    <x-editor-loader/>
</x-admin-layout>
