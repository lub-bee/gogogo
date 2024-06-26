<x-admin-layout>
    <form method ="POST" action="{{route('location.store')}}">
        @csrf

        <div class='section'>
            <h1>Location create</h1>
        </div>

        <div class= 'section'>
            <a href="{{ route('location.index')}}" class="btn">Back</a>
        </div>

        <div class='section'>
            <div class='block-container p-4'>

                {{-- title --}}
                <div class="info">
                    <div>Location Name <x-required/></div>
                    <div>
                        <x-input-error :messages="$errors->get('name')" class="mb-2" />
                        <input type="text" name="name" value="{{old("name")}}">
                    </div>
                </div>

                {{-- description (editor) --}}
                <div class="info">
                    <div>Location Description</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_en')" class="mb-2" />
                        <textarea name="description_en" class="w-full">{{old("description_en")}}</textarea>
                    </div>
                </div>

                {{-- gps long --}}
                <div class="info">
                    <div>GPS-Long</div>
                    <div>
                        <x-input-error :messages="$errors->get('gps_long')" class="mb-2" />
                        <input type="text" name="gps_long" value="{{old("gps_long")}}" class="w-full">
                    </div>
                </div>

                {{-- gps lat --}}
                <div class="info">
                    <div>GPS-Lat</div>
                    <div>
                        <x-input-error :messages="$errors->get('gps_lat')" class="mb-2" />
                        <input type="text" name="gps_lat" value="{{old("gps_lat")}}" class="w-full">
                    </div>
                </div>

                {{-- website url --}}
                <div class="info">
                    <div>Website URL</div>
                    <div>
                        <x-input-error :messages="$errors->get('website_url')" class="mb-2" />
                        <input type="url" name="website_url" value="{{old("website_url")}}" class="w-full">
                    </div>
                </div>

                {{-- cost --}}
                <div class="info">
                    <div>Cost</div>
                    <div>
                        <x-input-error :messages="$errors->get('cost')" class="mb-2" />
                        <input type="text" name="cost" value="{{old("cost")}}" class="w-full">
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-5">
                    <a href="{{ route('location.index') }}" class="btn">CANCEL</a>
                    <button type="submit" class="btn btn-main">SAVE</button>
                </div>
            </div>
        </div>
    </form>
</x-admin-layout>
