<x-admin-layout>
    <form method ="POST" action={{route('location.store')}}>
        @csrf

        <div class= 'section'>
            <a href={{ route('location.index')}} class="btn">Back</a>
        </div>

        <div class='section'>
            <div class='block-container p-4'>

                <div class="info">
                    <div>Location Name (Required) </div>
                    <div>
                        <input type="text" name="name" value="{{old("name")}}">
                        @error("name")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Location Description (English)</div>
                    <div class="col-span-3">
                        <textarea name="description_en" class="w-full">{{old("description_en")}}</textarea>
                        @error("description_en")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Location Description (Japanese)</div>
                    <div class="col-span-3">
                        <textarea name="description_ja" class="w-full"> {{old("description_ja")}}</textarea>
                        @error("description_ja")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>GPS-Long</div>
                    <div>
                        <input type="text" name="gps_long" value="{{old("gps_long")}}" class="w-full">
                        @error("gps_long")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>GPS-Lat</div>
                    <div>
                        <input type="text" name="gps_lat" value="{{old("gps_lat")}}" class="w-full">
                        @error("gps_lat")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Website URL</div>
                    <div>
                        <input type="url" name="website_url" value="{{old("website_url")}}" class="w-full">
                        @error("website_url")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Cost</div>
                    <div>
                        <input type="text" name="cost" value="{{old("cost")}}" class="w-full">
                        @error("cost")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-5">
                    <a href={{ route('location.index') }} class="btn">CANCEL</a>
                    <button type="submit" class="btn btn-main">SAVE</button>
                </div>
            </div>
        </div>
    </form>
</x-admin-layout>
