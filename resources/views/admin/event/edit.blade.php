<x-admin-layout>
        <h1
        class=
            "font-sans
            text-red-300
            antialiased
            "
        >
        Edit Event
        </h1>
        <form method="POST" action={{route('event.update',  $event->id)}}>

            @csrf
            @method('PUT')
            <div>
                <label>Event Name</label>
                <br>
                <input type="text" name="name" value="{{$event->name}}"/>
                @error("name")
                    <div>{{$message}}</div>
                @enderror
            </div>

            <div>
                <label>Cost</label>
                <br>
                <input type="text" name="cost" value="{{$event->cost}}"/>
                @error("cost")
                    <div>{{$message}}</div>
                @enderror
            </div>

            <div>
                <label>Description (English)</label>
                <br>
                <textarea name="description_en">{{$event->description_en}}</textarea>
                @error("description_en")
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div>
                <label>Description (Japanese)</label>
                <br>
                <textarea name="description_ja"> {{$event->description_ja}}</textarea>
                @error("description_ja")
                    <div>{{$message}}</div>
                @enderror
            </div>


            {{-- <div>
                <select name="select">
                    <option>Value 1</option>
                    <option>Value 2</option>
                    <option>Value 3</option>
                </select>
            </div> --}}

            <div>
                <button type="submit">
                    UPDATE
                </button>
            </div>
        </form>





{
    <div class="flex justify-between">
        <div>
            {{$event->name}}
        </div>
        <div>
            Last modification : {{$event->updated_at}}
        </div>
        <div>
            Author : {{$event->user_id}}
        </div>
    </div>
    <div>
        {{$event->description_en}}
    </div>
    <div>
        {{$event->description_ja}}
    </div>
}
</x-admin-layout>
