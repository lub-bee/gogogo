<x-admin-layout>
    <div class='section'>
        <a href={{ route('event.index')}} class="btn">Back</a>
    </div>
    <div class='section'>
        <div class='container p-4'>

            <form method="POST" action={{route('event.store')}}>

                @csrf

                <div class="info">
                    <div>Event Name</div>
                    <div>
                        <input type="text" name="name" value="{{old("name")}}"/>
                        @error("name")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Start</div>
                    <div>
                        <input type="date" name="start_at" value="{{old("start_at")}}" class="w-full"/>
                        @error("start_at")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                    <div>End</div>
                    <div>

                        <input type="date" name="end_at" value="{{old("end_at")}}" class="w-full"/>
                        @error("end_at")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Cost</div>
                    <div>
                        <input type="text" name="cost" value="{{old("cost")}}"/>
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
                        <textarea name="description_ja" class="w-full"> {{old("description_ja")}}</textarea>
                        @error("description_ja")
                        <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-5">
                    <a class="btn" href={{ route('event.index') }}>
                        CANCEL
                    </a>
                    <button type="submit" class="btn btn-main">
                        SAVE
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
