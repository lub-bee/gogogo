{{-- Edit location — management area --}}

<x-layouts.management title="Edit Location">

    <x-slot:heading>
        <i class="fa-solid fa-map-marker-alt fa-fw mr-2 text-lg"></i>Edit Location
    </x-slot:heading>

    <div class="max-w-2xl space-y-6">
        <form method="POST" action="{{ route('management.locations.update', $location) }}" class="bg-white rounded shadow-sm p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $location->name) }}" required
                       class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $location->slug) }}"
                       class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                @error('slug')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description EN --}}
            <div>
                <label for="description_en" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Description (EN)</label>
                <textarea name="description_en" id="description_en" rows="3"
                          class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500">{{ old('description_en', $location->description_en) }}</textarea>
                @error('description_en')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description JA --}}
            <div>
                <label for="description_ja" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Description (JA)</label>
                <textarea name="description_ja" id="description_ja" rows="3"
                          class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500">{{ old('description_ja', $location->description_ja) }}</textarea>
                @error('description_ja')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- GPS Coordinates --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="gps_lat" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">GPS Latitude</label>
                    <input type="number" name="gps_lat" id="gps_lat" value="{{ old('gps_lat', $location->gps_lat) }}" step="0.0000001"
                           class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                    @error('gps_lat')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="gps_lng" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">GPS Longitude</label>
                    <input type="number" name="gps_lng" id="gps_lng" value="{{ old('gps_lng', $location->gps_lng) }}" step="0.0000001"
                           class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                    @error('gps_lng')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Website URL --}}
            <div>
                <label for="website_url" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Website URL</label>
                <input type="url" name="website_url" id="website_url" value="{{ old('website_url', $location->website_url) }}" placeholder="https://"
                       class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                @error('website_url')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cost --}}
            <div>
                <label for="cost" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Cost</label>
                <input type="number" name="cost" id="cost" value="{{ old('cost', $location->cost) }}"
                       class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                @error('cost')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Event reference info --}}
            @if($location->events_count > 0)
                <div class="flex items-center gap-2 text-sm text-slate-500 bg-slate-50 px-3 py-2 rounded border border-slate-200">
                    <i class="fa-solid fa-circle-info text-slate-400"></i>
                    This location is referenced by <strong>{{ $location->events_count }}</strong> event(s).
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex items-center gap-4 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-slate-800 text-white px-5 py-2 rounded text-sm uppercase tracking-widest font-bold hover:bg-slate-700 transition-colors">
                    <i class="fa-solid fa-check"></i>Update Location
                </button>
                <a href="{{ route('management.locations.index') }}"
                   class="text-sm uppercase tracking-widest font-bold text-slate-500 hover:text-slate-700 transition-colors">
                    Back
                </a>
            </div>
        </form>

        {{-- Delete --}}
        <form method="POST" action="{{ route('management.locations.destroy', $location) }}"
              class="bg-white rounded shadow-sm p-6 border border-red-200"
              onsubmit="return confirm('{{ $location->events_count > 0 ? 'This location is used by ' . $location->events_count . ' event(s). Deleting it will clear their location field. ' : '' }}Delete location &quot;{{ addslashes($location->name) }}&quot;?')">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-widest text-red-600 font-bold">Danger Zone</p>
                    <p class="text-sm text-slate-500 mt-1">Permanently delete this location.</p>
                </div>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded text-sm uppercase tracking-widest font-bold hover:bg-red-500 transition-colors">
                    <i class="fa-solid fa-trash"></i>Delete
                </button>
            </div>
        </form>
    </div>

</x-layouts.management>
