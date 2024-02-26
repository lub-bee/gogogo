<x-admin-layout>
    <div class='section'>
        <a href={{route('topic.index')}} class="btn">Back</a>
    </div>
    <div class='section'>
        <div class='container p-4'>

            <form method="POST" action={{route('topic.store')}}>
                @csrf

                <div class="info">
                    <div>Topic Name</div>
                    <div>
                        <input type="text" name="name" value="{{old("name")}}"/>
                    @error("name")
                        <div>{{$message}}</div>
                    @enderror
                </div>

                <div>
                    <div>Description (English)</div>
                    <div>
                        <textarea name="description_en" class="w-full">{{old("description_en")}}</textarea>
                    @error("description_en")
                        <div>{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div>Description (Japanese)</div>
                    <div>
                        <textarea name="description_ja" class="w-full">{{old("description_ja")}}</textarea>
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

                <div class="flex justify-center gap-4 mt-5">
                    <a class="btn" href={{ route('topic.index') }}>
                        CANCEL
                    </a>
                    <button type="submit" class="btn btn-main">
                        SAVE
                    </button>
                </div>
    </form>
</x-admin-layout>
