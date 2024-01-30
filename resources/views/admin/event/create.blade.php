<x-admin-layout>
    <h1
    class=
        "font-sans
        text-red-300
        antialiased
        "
    >
    Create Event
    </h1>
    <form method="POST" action={{route('event.store')}}>

        @csrf

        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <div>
            <label>Event Name</label>
            <br>
            <input type="text" name="name" value="{{old("name")}}"/>
            @error("name")
                <div>{{$message}}</div>
            @enderror
        </div>

        <div>
            <label>Cost</label>
            <br>
            <input type="text" name="cost" value="{{old("cost")}}"/>
            @error("cost")
                <div>{{$message}}</div>
            @enderror
        </div>

        <div>
            <label>Description (English)</label>
            <br>
            <textarea name="description_en">{{old("description_en")}}</textarea>
            @error("description_en")
                <div>{{$message}}</div>
            @enderror
        </div>
        <div>
            <label>Description (Japanese)</label>
            <br>
            <textarea name="description_ja"> {{old("description_ja")}}</textarea>
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
                SAVE
            </button>
        </div>
    </form>
</x-admin-layout>
