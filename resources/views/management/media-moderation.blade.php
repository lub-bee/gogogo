<x-layouts.management title="Media Moderation">
    <x-slot:heading>
        <i class="fas fa-photo-video mr-2"></i> Media Moderation
    </x-slot:heading>

    {{-- Tab bar --}}
    <div class="flex items-center gap-1 mb-6 border-b border-slate-700">
        @php
            $tabs = [
                'pending'  => ['label' => 'Pending',  'icon' => 'fas fa-clock'],
                'approved' => ['label' => 'Approved', 'icon' => 'fas fa-check-circle'],
                'refused'  => ['label' => 'Refused',  'icon' => 'fas fa-ban'],
            ];
        @endphp
        @foreach ($tabs as $key => $t)
            <a href="{{ route('management.media', ['tab' => $key]) }}"
               class="px-4 py-2.5 text-sm font-medium border-b-2 transition-colors
                      {{ $tab === $key
                          ? 'border-white text-white'
                          : 'border-transparent text-slate-400 hover:text-slate-200' }}">
                <i class="{{ $t['icon'] }} mr-1"></i>
                {{ $t['label'] }}
                <span class="ml-1 text-xs px-1.5 py-0.5 rounded-full
                             {{ $tab === $key ? 'bg-slate-600 text-white' : 'bg-slate-700 text-slate-400' }}">
                    {{ $counts[$key] ?? 0 }}
                </span>
            </a>
        @endforeach
    </div>

    {{-- ============================================================ --}}
    {{-- PENDING TAB                                                   --}}
    {{-- ============================================================ --}}
    @if ($tab === 'pending')

        @if ($media->isEmpty())
            <div class="text-center py-16 text-slate-500">
                <i class="fas fa-inbox text-4xl mb-3"></i>
                <p class="text-sm">Inbox empty &mdash; nothing to moderate.</p>
            </div>
        @else
            <div x-data="{
                    selected: [],
                    toggleAll(checked) {
                        this.selected = checked
                            ? Array.from(document.querySelectorAll('[data-media-id]')).map(el => el.dataset.mediaId)
                            : [];
                    },
                    preview: null
                 }">

                {{-- Bulk actions --}}
                <div class="flex items-center justify-between mb-4" x-show="selected.length > 0" x-cloak>
                    <span class="text-sm text-slate-300">
                        <span x-text="selected.length"></span> selected
                    </span>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('management.media.bulk') }}">
                            @csrf
                            <template x-for="id in selected" :key="id">
                                <input type="hidden" name="media_ids[]" :value="id">
                            </template>
                            <button type="submit" name="action" value="approve"
                                    class="px-3 py-1.5 text-xs font-medium rounded bg-emerald-700 hover:bg-emerald-600 text-white">
                                <i class="fas fa-check mr-1"></i> Bulk Approve
                            </button>
                            <button type="submit" name="action" value="refuse"
                                    class="px-3 py-1.5 text-xs font-medium rounded bg-red-700 hover:bg-red-600 text-white ml-1">
                                <i class="fas fa-times mr-1"></i> Bulk Refuse
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Select all --}}
                <label class="flex items-center gap-2 mb-3 text-sm text-slate-400 cursor-pointer">
                    <input type="checkbox"
                           class="rounded border-slate-600 bg-slate-700 text-emerald-500 focus:ring-emerald-500"
                           @change="toggleAll($event.target.checked)">
                    Select all
                </label>

                {{-- Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    @foreach ($media as $item)
                        <div class="relative group bg-slate-800 border border-slate-700 rounded-lg overflow-hidden"
                             :data-media-id="'{{ $item->id }}'">
                            {{-- Checkbox --}}
                            <label class="absolute top-2 left-2 z-10 cursor-pointer">
                                <input type="checkbox" value="{{ $item->id }}"
                                       class="rounded border-slate-500 bg-slate-700/80 text-emerald-500 focus:ring-emerald-500"
                                       x-model="selected"
                                       data-media-id="{{ $item->id }}">
                            </label>

                            {{-- Thumbnail --}}
                            <div class="aspect-square cursor-pointer"
                                 @click="preview = {
                                     id: {{ $item->id }},
                                     src: '{{ $item->url }}',
                                     user: '{{ addslashes($item->user->name ?? 'Unknown') }}',
                                     event: '{{ addslashes($item->event->name ?? '') }}',
                                     legend: '{{ addslashes($item->legend ?? '') }}',
                                     date: '{{ $item->created_at->format('Y-m-d H:i') }}'
                                 }">
                                <img src="{{ $item->url }}" alt=""
                                     class="w-full h-full object-cover">
                            </div>

                            {{-- Info --}}
                            <div class="p-2">
                                <div class="text-xs text-slate-300 truncate">{{ $item->user->name ?? 'Unknown' }}</div>
                                <div class="text-[11px] text-slate-500 truncate">{{ $item->event->name ?? '' }}</div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex border-t border-slate-700">
                                <form method="POST" action="{{ route('management.media.approve', $item) }}" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                            class="w-full py-1.5 text-xs text-emerald-400 hover:bg-emerald-900/40 transition-colors">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('management.media.refuse', $item) }}" class="flex-1 border-l border-slate-700">
                                    @csrf
                                    <button type="submit"
                                            class="w-full py-1.5 text-xs text-red-400 hover:bg-red-900/40 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Preview overlay --}}
                <div x-show="preview" x-cloak
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
                     @click.self="preview = null"
                     @keydown.escape.window="preview = null">
                    <div class="bg-slate-800 border border-slate-700 rounded-lg max-w-3xl w-full max-h-[90vh] overflow-auto"
                         x-show="preview" x-transition>
                        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-700">
                            <h3 class="text-sm font-medium text-white">Preview</h3>
                            <button @click="preview = null" class="text-slate-400 hover:text-white">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <img :src="preview?.src" alt="" class="max-w-full max-h-[60vh] mx-auto rounded">
                            <div class="mt-4 space-y-1 text-sm text-slate-300">
                                <div><span class="text-slate-500">User:</span> <span x-text="preview?.user"></span></div>
                                <div><span class="text-slate-500">Event:</span> <span x-text="preview?.event"></span></div>
                                <div x-show="preview?.legend">
                                    <span class="text-slate-500">Legend:</span> <span x-text="preview?.legend"></span>
                                </div>
                                <div><span class="text-slate-500">Date:</span> <span x-text="preview?.date"></span></div>
                            </div>
                        </div>
                        <div class="flex gap-2 px-4 py-3 border-t border-slate-700">
                            <form :action="'/management/media/' + preview?.id + '/approve'" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="w-full py-2 text-sm font-medium rounded bg-emerald-700 hover:bg-emerald-600 text-white">
                                    <i class="fas fa-check mr-1"></i> Approve
                                </button>
                            </form>
                            <form :action="'/management/media/' + preview?.id + '/refuse'" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="w-full py-2 text-sm font-medium rounded bg-red-700 hover:bg-red-600 text-white">
                                    <i class="fas fa-times mr-1"></i> Refuse
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        @endif

    {{-- ============================================================ --}}
    {{-- APPROVED TAB                                                  --}}
    {{-- ============================================================ --}}
    @elseif ($tab === 'approved')

        @if ($media->isEmpty())
            <div class="text-center py-16 text-slate-500">
                <i class="fas fa-check-circle text-4xl mb-3"></i>
                <p class="text-sm">No approved media.</p>
            </div>
        @else
            <div class="space-y-2">
                @foreach ($media as $item)
                    <div class="flex items-center gap-4 bg-slate-800 border border-slate-700 rounded-lg p-3">
                        {{-- Thumbnail --}}
                        <div class="w-16 h-16 flex-shrink-0 rounded overflow-hidden">
                            <img src="{{ $item->url }}" alt="" class="w-full h-full object-cover">
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="text-sm text-white truncate">{{ $item->user->name ?? 'Unknown' }}</div>
                            <div class="text-xs text-slate-400 truncate">{{ $item->event->name ?? '' }}</div>
                            <div class="text-[11px] text-slate-500 mt-0.5">{{ $item->created_at->format('Y-m-d H:i') }}</div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <form method="POST" action="{{ route('management.media.refuse', $item) }}"
                                  onsubmit="return confirm('Re-refuse this media? The original file will be permanently deleted.')">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-medium rounded bg-amber-700 hover:bg-amber-600 text-white">
                                    <i class="fas fa-undo mr-1"></i> Re-refuse
                                </button>
                            </form>
                            <form method="POST" action="{{ route('management.media.destroy', $item) }}"
                                  onsubmit="return confirm('Permanently delete this media?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-medium rounded bg-red-700 hover:bg-red-600 text-white">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    {{-- ============================================================ --}}
    {{-- REFUSED TAB                                                   --}}
    {{-- ============================================================ --}}
    @elseif ($tab === 'refused')

        @if ($media->isEmpty())
            <div class="text-center py-16 text-slate-500">
                <i class="fas fa-ban text-4xl mb-3"></i>
                <p class="text-sm">No refused media.</p>
            </div>
        @else
            <div class="mb-4 px-3 py-2 rounded bg-slate-800 border border-slate-700 text-xs text-slate-400">
                <i class="fas fa-info-circle mr-1"></i>
                Refused media cannot be re-approved &mdash; the original file has been deleted.
            </div>

            <div class="space-y-2">
                @foreach ($media as $item)
                    <div class="flex items-center gap-4 bg-slate-800 border border-slate-700 rounded-lg p-3 opacity-60">
                        {{-- Thumbnail (greyed) --}}
                        <div class="w-16 h-16 flex-shrink-0 rounded overflow-hidden grayscale">
                            <img src="{{ $item->url }}" alt="" class="w-full h-full object-cover">
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="text-sm text-white truncate">{{ $item->user->name ?? 'Unknown' }}</div>
                            <div class="text-xs text-slate-400 truncate">{{ $item->event->name ?? '' }}</div>
                            <div class="text-[11px] text-slate-500 mt-0.5">{{ $item->created_at->format('Y-m-d H:i') }}</div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex-shrink-0">
                            <form method="POST" action="{{ route('management.media.destroy', $item) }}"
                                  onsubmit="return confirm('Permanently delete this media record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-medium rounded bg-red-700 hover:bg-red-600 text-white">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    @endif

    {{-- Pagination --}}
    @if ($media->hasPages())
        <div class="mt-6">
            {{ $media->appends(['tab' => $tab])->links() }}
        </div>
    @endif

</x-layouts.management>
