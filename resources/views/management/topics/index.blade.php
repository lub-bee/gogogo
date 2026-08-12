{{-- Topics listing — management area --}}

<x-layouts.management title="Topics">

    <x-slot:heading>
        <i class="fa-solid fa-book-open fa-fw mr-2 text-lg"></i>Topics
    </x-slot:heading>

    <x-slot:headingActions>
        <a href="{{ route('management.topics.create') }}"
           class="inline-flex items-center gap-2 bg-white text-slate-800 px-4 py-2 rounded text-sm uppercase tracking-widest font-bold hover:bg-slate-200 transition-colors">
            <i class="fa-solid fa-plus"></i>New Topic
        </a>
    </x-slot:headingActions>

    <div class="bg-white rounded shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-left">
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold">Name</th>
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold">Published</th>
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold">Events</th>
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold">Source Doc</th>
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($topics as $topic)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3">
                            <a href="{{ route('management.topics.edit', $topic) }}" class="font-bold text-slate-800 hover:text-slate-600">
                                {{ $topic->name }}
                            </a>
                        </td>
                        <td class="px-4 py-3">
                            @if($topic->published_at)
                                <span class="inline-block bg-green-100 text-green-700 text-xs uppercase tracking-widest font-bold px-2 py-0.5 rounded">Published</span>
                            @else
                                <span class="inline-block bg-slate-200 text-slate-500 text-xs uppercase tracking-widest font-bold px-2 py-0.5 rounded">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $topic->events_count }}</td>
                        <td class="px-4 py-3">
                            @if($topic->source_doc_id)
                                <i class="fa-solid fa-file-lines text-slate-400" title="Linked to Google Doc: {{ $topic->source_doc_id }}"></i>
                            @else
                                <span class="text-slate-300">&mdash;</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('management.topics.edit', $topic) }}"
                                   class="text-xs uppercase tracking-widest font-bold text-slate-500 hover:text-slate-700 transition-colors">
                                    <i class="fa-solid fa-pen-to-square fa-fw"></i> Edit
                                </a>

                                @unless($topic->published_at)
                                    <form method="POST" action="{{ route('management.topics.publish', $topic) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="text-xs uppercase tracking-widest font-bold text-green-600 hover:text-green-500 transition-colors">
                                            <i class="fa-solid fa-eye fa-fw"></i> Publish
                                        </button>
                                    </form>
                                @endunless

                                <form method="POST" action="{{ route('management.topics.destroy', $topic) }}" class="inline"
                                      onsubmit="return confirm('Delete topic &quot;{{ addslashes($topic->name) }}&quot;? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs uppercase tracking-widest font-bold text-red-500 hover:text-red-400 transition-colors">
                                        <i class="fa-solid fa-trash fa-fw"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-slate-400 text-sm uppercase tracking-widest">
                            No topics yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $topics->links() }}
    </div>

    <p class="mt-6 text-xs text-slate-400 uppercase tracking-widest">
        <i class="fa-solid fa-circle-info fa-fw mr-1"></i>
        Topics are normally created automatically via the Google Docs API. This manual interface is the admin fallback.
    </p>

</x-layouts.management>
