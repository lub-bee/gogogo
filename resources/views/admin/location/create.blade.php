<x-admin-layout>
    <h1
    class=
        "font-sans
        text-red-300
        antialiased
        "
    >
    Create Location
    </h1>
    <form method="POST" action={{route('location.store')}}>
            {{-- ASK - DOES IS MATTER WHERE @csrf IS IN THE PAGE????--}}
        @csrf

        <div>
            <label>Location Name</label>
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
            <label>Location Description (English)</label>
            <br>
            <textarea name="description_en">{{old("description_en")}}</textarea>
            @error("description_en")
                <div>{{$message}}</div>
            @enderror
        </div>

        <div>
            <label>Location Description (Japanese)</label>
            <br>
            <textarea name="description_ja"> {{old("description_ja")}}</textarea>
            @error("description_ja")
                <div>{{$message}}</div>
            @enderror
        </div>

        <div>
            <label>Website URL</label>
            <br>
            <textarea name="website_url"> {{old("website_url")}}</textarea>
            @error("website_url")
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
