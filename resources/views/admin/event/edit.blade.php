<x-admin-layout>
    <form method="POST" action="{{route('event.update',  $event->id)}}">
        @csrf
        @method('PUT')

        <div class='section'>
            <a href="{{ route('event.show', $event->id)}}" class="btn">Back</a>
        </div>

        <div class='section'>
            <div class='block-container p-4 '>

                <div class="info">
                    <div>Name (Required) </div>
                    <div>
                        <input type="text" name="name" value="{{old('name', $event->name)}}">

                        @error("name")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Start (Required) </div>
                    <div>
                        <input
                            type="datetime-local"
                            name="start_at"
                            value="{{old('start_at',$event->start_at)}}"
                        />
                        <!--
                        @php
                            echo old('test', "something"); //=> if the value $test is not set, then use "something" as default value
                            echo old("name", $event->name);
                        @endphp
                        -->


                        @error("start_at")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                    <div>End</div>
                    <div>
                        <input type="datetime-local" name="end_at" value="{{old('end_at', $event->end_at)}}"/>
                        @error("end_at")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Cost</div>
                    <div>
                        <input type="text" name="cost" value="{{old('cost', $event->cost)}}"/>
                        @error("cost")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Content (EN)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_en')" class="mb-2" />
                        <textarea id="description_en" name="description_en" class="hidden"></textarea>
                        <div id="editor_en" class="">{!! old('description_en', $topic->description_en) !!}</div>
                    </div>
                </div>

                <div class="info">
                    <div>Content (JA)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_ja')" class="mb-2" />
                        <textarea id="description_ja" name="description_ja" class="hidden"></textarea>
                        <div id="editor_ja" class="">{!! old('description_ja', $topic->description_ja) !!}</div>
                    </div>
                </div>

                <div class="info">
                    <div>Topic</div>
                    <div>
                        <select name="topic_id">
                            <option value="" >-</option>
                            @foreach ($topics as $topic)
                                <option value="{{$topic->id}}" {{ (old("topic_id", $event->topic_id) == $topic->id ? "selected":"") }} >{{ $topic->name }}</option>
                            @endforeach
                        </select>
                        @error("topic_id")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Location</div>
                    <div>
                        <select name="location_id">
                            <option value="" >-</option>
                            @foreach ($locations as $location)
                                <option value="{{$location->id}}" {{ (old("location_id", $event->location_id) == $location->id ? "selected":"") }} >{{ $location->name }}</option>
                            @endforeach
                        </select>
                        @error("location_id")
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
                                    value="draft"
                                    {{ old("status",$event->publish_status) == 'draft' ? 'checked' : '' }}
                                />
                                Draft
                            </label>
                            @error("status")
                                <div>{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            <label>
                                <input
                                    type="radio"
                                    name="status"
                                    value="published"
                                    {{ old("status",$event->publish_status) == 'published' ? 'checked' : '' }}
                                />
                                Published
                            </label>
                            <input type="date" name="published_at"/>
                            @error("published_at")
                                <div>{{$message}}</div>
                            @enderror
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

    <form method="POST" action="{{ route('event.destroy') }}" >
        @csrf
        @method("delete")
        <div class='section'>
            <div class='block-container p-4 '>

                <input type="hidden" name="event_id" value="{{$event->id}}" />

                <div class="text-xl">
                    Delete the event
                </div>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </form>

</x-admin-layout>
