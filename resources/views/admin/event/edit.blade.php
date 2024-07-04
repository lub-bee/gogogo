<x-admin-layout>

    <div class='section'>
        <h1>Event Edit</h1>
    </div>

    {{-- nav --}}
    <div class='section'>
        <a href="{{ route('event.show', $event->id)}}" class="btn">Back</a>
    </div>

    {{-- event edit form --}}
    <form method="POST" action="{{route('event.update')}}">
        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{$event->id}}"/>

        <div class='section'>
            <div class='block-container p-4 '>

                {{-- event name --}}
                <div class="info">
                    <div>Name <x-required/></div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('name')" class="mb-2" />
                        <input type="text" name="name" class="form-input" value="{{old('name', $event->name)}}">
                    </div>
                </div>

                {{-- event slug --}}
                <div class="info">
                    <div>Slug <x-required/></div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('slug')" class="mb-2" />
                        <input type="text" name="slug" class="form-input" value="{{old('slug', $event->slug)}}">
                    </div>
                </div>

                <div class="info">
                    {{-- event start --}}
                    <div>Start <x-required/></div>
                    <div>
                        <x-input-error :messages="$errors->get('start_at')" class="mb-2" />
                        <input
                            type="datetime-local"
                            class="form-input"
                            name="start_at"
                            value="{{old('start_at',$event->start_at)}}"
                        />
                    </div>

                    {{-- event end --}}
                    <div>End</div>
                    <div>
                        <x-input-error :messages="$errors->get('end_at')" class="mb-2" />
                        <input type="datetime-local" class="form-input" name="end_at" value="{{old('end_at', $event->end_at)}}"/>
                    </div>
                </div>

                {{-- event cost --}}
                <div class="info">
                    <div>Cost</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('cost')" class="mb-2" />
                        <input type="text" class="form-input" name="cost" value="{{old('cost', $event->cost)}}"/>
                    </div>
                </div>

                {{-- event description EN (editor) --}}
                <div class="info">
                    <div>Content (EN)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_en')" class="mb-2" />
                        <textarea id="description_en" name="description_en" class="hidden"></textarea>
                        <div id="editor_en" class="">{!! old('description_en', $event->description_en) !!}</div>
                    </div>
                </div>

                {{-- event description JA (editor) --}}
                <div class="info">
                    <div>Content (JA)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_ja')" class="mb-2" />
                        <textarea id="description_ja" name="description_ja" class="hidden"></textarea>
                        <div id="editor_ja" class="">{!! old('description_ja', $event->description_ja) !!}</div>
                    </div>
                </div>

                {{-- event topic --}}
                <div class="info">
                    <div>Topic</div>
                    <div class="col-span-2">
                        <x-input-error :messages="$errors->get('topic_id')" class="mb-2" />
                        <select name="topic_id" class="form-input">
                            <option value="" >-</option>
                            @foreach ($topics as $topic)
                                <option value="{{$topic->id}}" {{ (old("topic_id", $event->topic_id) == $topic->id ? "selected":"") }} >{{ $topic->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- event location --}}
                <div class="info">
                    <div>Location</div>
                    <div class="col-span-2">
                        <x-input-error :messages="$errors->get('location_id')" class="mb-2" />
                        <select name="location_id" class="form-input">
                            <option value="" >-</option>
                            @foreach ($locations as $location)
                                <option value="{{$location->id}}" {{ (old("location_id", $event->location_id) == $location->id ? "selected":"") }} >{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- event status --}}
                <div class="info">
                    <div>Status</div>
                    <div class="col-span-3">
                        <div>
                            <x-input-error :messages="$errors->get('status')" class="mb-2" />
                            <label>
                                <input
                                    type="radio"
                                    name="status"
                                    value="draft"
                                    {{ old("status",$event->publish_status) == 'draft' ? 'checked' : '' }}
                                />
                                Draft
                            </label>
                        </div>
                        <div>
                            <label>
                                <x-input-error :messages="$errors->get('published_at')" class="mb-2" />
                                <input
                                    type="radio"
                                    name="status"
                                    value="published"
                                    {{ old("status",$event->publish_status) == 'published' ? 'checked' : '' }}
                                />
                                Published
                            </label>
                            <div class='inline-block'>
                                <input type="date" name="published_at" class="form-input"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex mt-5 gap-4 justify-center">
                    <a href="{{ route('event.show', $event->id)}}" class="btn">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-main">
                        Edit
                    </button>
                </div>

            </div>
        </div>
    </form>

    <x-event.event-delete-form :event="$event"/>

    <x-editor-loader/>

</x-admin-layout>
