{{-- Create location — management area --}}

<x-layouts.management title="New Location">

    <x-slot:heading>
        <i class="fa-solid fa-map-marker-alt fa-fw mr-2 text-lg"></i>New Location
    </x-slot:heading>

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('management.locations.store') }}" class="bg-white rounded shadow-sm p-6 space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description EN --}}
            <div>
                <label for="description_en" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Description (EN)</label>
                <textarea name="description_en" id="description_en" rows="3"
                          class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500">{{ old('description_en') }}</textarea>
                @error('description_en')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description JA --}}
            <div>
                <label for="description_ja" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Description (JA)</label>
                <textarea name="description_ja" id="description_ja" rows="3"
                          class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500">{{ old('description_ja') }}</textarea>
                @error('description_ja')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- GPS Coordinates --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="gps_lat" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">GPS Latitude</label>
                    <input type="number" name="gps_lat" id="gps_lat" value="{{ old('gps_lat') }}" step="0.0000001"
                           class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                    @error('gps_lat')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="gps_lng" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">GPS Longitude</label>
                    <input type="number" name="gps_lng" id="gps_lng" value="{{ old('gps_lng') }}" step="0.0000001"
                           class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                    @error('gps_lng')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Website URL --}}
            <div>
                <label for="website_url" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Website URL</label>
                <input type="url" name="website_url" id="website_url" value="{{ old('website_url') }}" placeholder="https://"
                       class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                @error('website_url')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cost --}}
            <div>
                <label for="cost" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Cost</label>
                <input type="number" name="cost" id="cost" value="{{ old('cost') }}"
                       class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                @error('cost')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-slate-800 text-white px-5 py-2 rounded text-sm uppercase tracking-widest font-bold hover:bg-slate-700 transition-colors">
                    <i class="fa-solid fa-check"></i>Create Location
                </button>
                <a href="{{ route('management.locations.index') }}"
                   class="text-sm uppercase tracking-widest font-bold text-slate-500 hover:text-slate-700 transition-colors">
                    Back
                </a>
            </div>
        </form>
    </div>

</x-layouts.management>
