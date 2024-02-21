<x-admin-layout>
    <form method="POST" action={{route('event.update',  $event->id)}}>
        @csrf
        @method('PUT')

        <div class='section'>
            <a href={{ route('event.show', $event->id)}} class="btn">Back</a>
        </div>

        <div class='section'>
            <div class='container p-4 '>

                <div class="info">
                    <div>Name</div>
                    <div>
                        <input type="text" name="name" value="{{$event->name}}"/>
                        @error("name")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Start</div>
                    <div>
                        <input type="text" name="start_at" value="{{$event->start_at}}"/>
                        @error("start_at")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                    <div>End</div>
                    <div>
                        <input type="text" name="end_at" value="{{$event->end_at}}"/>
                        @error("end_at")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Cost</div>
                    <div>
                        <input type="text" name="cost" value="{{$event->cost}}"/>
                        @error("cost")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Description (English)</div>
                    <div class="col-span-3">
                        <textarea name="description_en" class="w-full">{{$event->description_en}}</textarea>
                        @error("description_en")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Description (Japanese)</div>
                    <div class="col-span-3">
                        <textarea name="description_ja" class="w-full"> {{$event->description_ja}}</textarea>
                        @error("description_ja")
                            <div>{{$message}}</div>
                        @enderror
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

</x-admin-layout>
