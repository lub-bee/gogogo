<x-admin-layout>
    <form method="POST" action={{route('event.update',  $event->id)}}>
        @csrf
        @method('PUT')

        <div class='section'>
            <a href={{ route('event.show', $event->id)}} class="btn">Back</a>
        </div>

        <div class='section'>
            <div class='block-container p-4 '>

                <div class="info">
                    <div>Name</div>
                    <div>
                        <input type="text" name="name" value={{old("name", $event->name)}}>
                        @error("name")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Start</div>
                    <div>
                        <input type="datetime-local" name="start_at" value={{old('start_at',$event->start_at)}}>

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
                        <input type="datetime-local" name="end_at" value={{old('end_at', $event->end_at)}}>
                        @error("end_at")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Cost</div>
                    <div>
                        <input type="text" name="cost" value={{old('cost', $event->cost)}}>
                        @error("cost")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Description (English)</div>
                    <div class="col-span-3">
                        <textarea name="description_en" class="w-full">{{old('descriotion_en', $event->description_en)}}</textarea>
                        @error("description_en")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Description (Japanese)</div>
                    <div class="col-span-3">
                        <textarea name="description_ja" class="w-full"> {{old('descriotion_ja',$event->description_ja)}}</textarea>
                        @error("description_ja")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Status</div>
                    <div class="col-span-3">
                        <div>
                            <label><input type="radio" name="status" value="draft" {{ old("status",$event->status, 'draft') == 'draft' ? 'checked' : '' }}> Draft</label>
                        </div>
                        <div>
                            <label><input type="radio" name="status" value="published" {{ old("status",$event->status, 'draft') == 'published' ? 'checked' : '' }}> Published</label>
                        </div>
                    </div>
                </div>

                <div class="flex mt-5 gap-4 justify-center">
                    <a href={{ route('event.show', $event->id)}} class="btn">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-main">
                        Edit
                    </button>
                </div>

            </div>
        </div>
    </form>

    <form method="POST" action={{ route('event.destroy') }} >
        <div class='section'>
            <div class='block-container p-4 '>
                @csrf
                @method("delete")

                <input type="hidden" name="event_id" value={{$event->id}} />

                <div class="text-xl">
                    Delete the event
                </div>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </form>

</x-admin-layout>
