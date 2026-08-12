{{-- Edit topic — management area --}}

<x-layouts.management title="Edit Topic">

    <x-slot:heading>
        <i class="fa-solid fa-book-open fa-fw mr-2 text-lg"></i>Edit Topic
    </x-slot:heading>

    <div class="max-w-2xl space-y-6">
        <form method="POST" action="{{ route('management.topics.update', $topic) }}" class="bg-white rounded shadow-sm p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $topic->name) }}" required
                       class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $topic->slug) }}"
                       class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" />
                @error('slug')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Memo --}}
            <div>
                <label for="memo" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Memo</label>
                <textarea name="memo" id="memo" rows="2"
                          class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500">{{ old('memo', $topic->memo) }}</textarea>
                @error('memo')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description EN --}}
            <div>
                <label for="description_en" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Description (EN)</label>
                <textarea name="description_en" id="description_en" rows="5"
                          class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500">{{ old('description_en', $topic->description_en) }}</textarea>
                @error('description_en')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description JA --}}
            <div>
                <label for="description_ja" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Description (JA)</label>
                <textarea name="description_ja" id="description_ja" rows="5"
                          class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500">{{ old('description_ja', $topic->description_ja) }}</textarea>
                @error('description_ja')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Source Doc ID (readonly info) --}}
            @if($topic->source_doc_id)
                <div>
                    <span class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Source Doc ID</span>
                    <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-3 py-2 rounded border border-slate-200">
                        <i class="fa-solid fa-file-lines text-slate-400"></i>
                        <code class="text-xs">{{ $topic->source_doc_id }}</code>
                    </div>
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex items-center gap-4 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-slate-800 text-white px-5 py-2 rounded text-sm uppercase tracking-widest font-bold hover:bg-slate-700 transition-colors">
                    <i class="fa-solid fa-check"></i>Update Topic
                </button>
                <a href="{{ route('management.topics.index') }}"
                   class="text-sm uppercase tracking-widest font-bold text-slate-500 hover:text-slate-700 transition-colors">
                    Back
                </a>
            </div>
        </form>

        {{-- Delete --}}
        <form method="POST" action="{{ route('management.topics.destroy', $topic) }}"
              class="bg-white rounded shadow-sm p-6 border border-red-200"
              onsubmit="return confirm('Delete topic &quot;{{ addslashes($topic->name) }}&quot;? This cannot be undone.')">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-widest text-red-600 font-bold">Danger Zone</p>
                    <p class="text-sm text-slate-500 mt-1">Permanently delete this topic and remove it from all events.</p>
                </div>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded text-sm uppercase tracking-widest font-bold hover:bg-red-500 transition-colors">
                    <i class="fa-solid fa-trash"></i>Delete
                </button>
            </div>
        </form>
    </div>

</x-layouts.management>
