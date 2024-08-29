<x-admin-layout>

    <div class='section'>
        <h1>Location edit</h1>
    </div>

    <div class='section'>
        <a href="{{route('location.show', $location->id)}}" class="btn">Back</a>
    </div>

    <form method="POST" action="{{route('location.update', $location->id)}}">
        @method('PUT')
        @csrf

        <div class='section'>
            <div class='block-container p-4 '>

                {{-- title --}}
                <div class="info">
                    <div>Location Name <x-required/></div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('name')" class="mb-2" />
                        <input type="text" name="name" class="form-input" value="{{old('name',$location->name)}}">
                    </div>
                </div>

                {{-- slug --}}
                <div class="info">
                    <div>Slug <x-required/></div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('slug')" class="mb-2" />
                        <input type="text" name="slug" class="form-input" value="{{old('slug',$location->slug)}}">
                    </div>
                </div>

                {{-- description --}}
                <div class="info">
                    <div>Location Description</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_en')" class="mb-2" />
                        <textarea name="description_en" class="form-input">{{old('description_en', $location->description_en)}}</textarea>
                    </div>
                </div>

                <div class="info">
                    {{-- gps long --}}
                    <div>GPS-Long</div>
                    <div>
                        <x-input-error :messages="$errors->get('gps_long')" class="mb-2" />
                        <input type="text" name="gps_long" class="form-input" value="{{old('gps_long', $location->gps_long)}}"/>
                    </div>

                    {{-- gps lat --}}
                    <div>GPS-Lat</div>
                    <div>
                        <x-input-error :messages="$errors->get('gps_lat')" class="mb-2" />
                        <input type="text" name="gps_lat" value="{{old('gps_lat', $location->gps_lat)}}" class="form-input"/>
                    </div>
                </div>

                {{-- website url --}}
                <div class="info">
                    <div>Website URL</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('website_url')" class="mb-2" />
                        <input type="url" name="website_url" value="{{old('website_url',$location->website_url)}}" class="form-input"/>
                    </div>
                </div>

                {{-- cost --}}
                <div class="info">
                    <div>Cost</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('cost')" class="mb-2" />
                        <input type="text" name="cost" value="{{old('cost', $location->cost)}}" class="form-input"/>
                    </div>
                </div>

                <div class="flex mt-5 gap-4 justify-center">
                    <a href="{{ route('location.show', $location->id) }}" class="btn">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-main">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </form>

    <x-location.location-delete-form :location="$location"/>


</x-admin-layout>

