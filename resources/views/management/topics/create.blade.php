{{-- Create topic — management area --}}

<x-layouts.management title="New Topic">

    <x-slot:heading>
        <i class="fa-solid fa-book-open fa-fw mr-2 text-lg"></i>New Topic
    </x-slot:heading>

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('management.topics.store') }}" class="bg-white rounded shadow-sm p-6 space-y-5">
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

            {{-- Memo --}}
            <div>
                <label for="memo" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Memo</label>
                <textarea name="memo" id="memo" rows="2"
                          class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500">{{ old('memo') }}</textarea>
                @error('memo')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description EN --}}
            <div>
                <label for="description_en" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Description (EN)</label>
                <textarea name="description_en" id="description_en" rows="5"
                          class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500">{{ old('description_en') }}</textarea>
                @error('description_en')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description JA --}}
            <div>
                <label for="description_ja" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Description (JA)</label>
                <textarea name="description_ja" id="description_ja" rows="5"
                          class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500">{{ old('description_ja') }}</textarea>
                @error('description_ja')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-slate-800 text-white px-5 py-2 rounded text-sm uppercase tracking-widest font-bold hover:bg-slate-700 transition-colors">
                    <i class="fa-solid fa-check"></i>Create Topic
                </button>
                <a href="{{ route('management.topics.index') }}"
                   class="text-sm uppercase tracking-widest font-bold text-slate-500 hover:text-slate-700 transition-colors">
                    Back
                </a>
            </div>
        </form>
    </div>

</x-layouts.management>
