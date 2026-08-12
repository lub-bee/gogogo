<x-layouts.management :title="'Create Event'">
    <x-slot:heading>
        <h1 class="text-lg font-bold uppercase tracking-widest text-white">
            <i class="fa-solid fa-calendar-plus mr-2"></i>Create Event
        </h1>
    </x-slot:heading>

    <div class="max-w-3xl">
        <form action="{{ route('management.events.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">
                    Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="form-input w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type --}}
            <div>
                <label for="type" class="block text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">
                    Type <span class="text-red-500">*</span>
                </label>
                <select name="type" id="type"
                        class="form-select w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach ($types as $type)
                        <option value="{{ $type->value }}" @selected(old('type') === $type->value)>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Dates --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_at" class="block text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">
                        Start <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="start_at" id="start_at" value="{{ old('start_at') }}" required
                           class="form-input w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('start_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_at" class="block text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">
                        End <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="end_at" id="end_at" value="{{ old('end_at') }}" required
                           class="form-input w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('end_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Description EN --}}
            <div>
                <label for="description_en" class="block text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">
                    Description (English)
                </label>
                <textarea name="description_en" id="description_en" rows="5"
                          class="form-textarea w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description_en') }}</textarea>
                @error('description_en')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description JA --}}
            <div>
                <label for="description_ja" class="block text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">
                    Description (Japanese)
                </label>
                <textarea name="description_ja" id="description_ja" rows="5"
                          class="form-textarea w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description_ja') }}</textarea>
                @error('description_ja')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cost --}}
            <div>
                <label for="cost" class="block text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">
                    Cost (JPY)
                </label>
                <input type="number" name="cost" id="cost" value="{{ old('cost') }}" step="1" min="0"
                       class="form-input w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                       placeholder="Leave blank if free">
                @error('cost')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Location --}}
            <div>
                <label for="location_id" class="block text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">
                    Location
                </label>
                <select name="location_id" id="location_id"
                        class="form-select w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">— None —</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('management.locations.create') }}"
                   class="inline-block mt-1 text-xs text-indigo-600 hover:text-indigo-500 transition">
                    <i class="fa-solid fa-plus mr-1"></i>Or create a new location
                </a>
                @error('location_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Topic --}}
            <div>
                <label for="topic_id" class="block text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">
                    Topic
                </label>
                <select name="topic_id" id="topic_id"
                        class="form-select w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">— None —</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}" @selected(old('topic_id') == $topic->id)>
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
                @error('topic_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4 pt-4 border-t border-slate-200">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition">
                    <i class="fa-solid fa-check"></i> Create Event
                </button>
                <a href="{{ route('management.events.index') }}"
                   class="text-sm text-slate-500 hover:text-slate-700 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i>Back to events
                </a>
            </div>
        </form>
    </div>
</x-layouts.management>
