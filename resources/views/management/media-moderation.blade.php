{{--
    Media moderation inbox — admin/support only.
    Grid of pending thumbnails with individual + bulk accept/refuse.
--}}

<x-layouts.public
    :menuBack="['url' => url('/'), 'label' => 'Back']"
    title="Media Moderation — GoGoGo">

    <main class="min-h-screen bg-slate-100">
        {{-- Header bar --}}
        <div class="bg-slate-700 text-white px-4 md:px-8 py-4">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="text-2xl md:text-4xl font-bold uppercase -tracking-[0.06em]">
                    <i class="fa-solid fa-shield-halved fa-fw mr-2 text-lg"></i>Media Moderation
                </div>
                <div class="text-sm uppercase tracking-widest text-slate-300 font-bold">
                    {{ $pending->count() }} pending
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 md:px-8 py-6" x-data="{
            selected: [],
            selectAll: false,
            toggleAll() {
                if (this.selectAll) {
                    this.selected = Array.from(document.querySelectorAll('[data-media-id]')).map(el => el.dataset.mediaId);
                } else {
                    this.selected = [];
                }
            },
            preview: null,
            openPreview(media) {
                this.preview = media;
            },
            closePreview() {
                this.preview = null;
            }
        }">

            @if(session('status'))
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded text-sm uppercase tracking-widest font-bold">
                    <i class="fa-solid fa-check mr-1"></i>{{ session('status') }}
                </div>
            @endif

            @if($pending->count() > 0)
                {{-- Bulk actions bar --}}
                <div class="flex items-center gap-4 mb-4 bg-white p-3 rounded shadow-sm">
                    <label class="flex items-center gap-2 cursor-pointer text-sm uppercase tracking-widest text-slate-500 font-bold">
                        <input type="checkbox" x-model="selectAll" @change="toggleAll()" class="rounded border-slate-400" />
                        Select all
                    </label>
                    <div class="flex-1"></div>
                    <template x-if="selected.length > 0">
                        <div class="flex items-center gap-2">
                            <span class="text-sm uppercase tracking-widest text-slate-500 font-bold" x-text="selected.length + ' selected'"></span>
                            <form method="POST" action="{{ route('management.media.bulk') }}" class="inline">
                                @csrf
                                <template x-for="id in selected" :key="id">
                                    <input type="hidden" name="media_ids[]" :value="id" />
                                </template>
                                <button type="submit" name="action" value="approve" class="btn btn-success text-base">
                                    <i class="fa-solid fa-check mr-1"></i>Accept
                                </button>
                            </form>
                            <form method="POST" action="{{ route('management.media.bulk') }}" class="inline">
                                @csrf
                                <template x-for="id in selected" :key="id">
                                    <input type="hidden" name="media_ids[]" :value="id" />
                                </template>
                                <button type="submit" name="action" value="refuse" class="btn btn-danger text-base"
                                        onclick="return confirm('Refuse selected items? Original files will be deleted.')">
                                    <i class="fa-solid fa-xmark mr-1"></i>Refuse
                                </button>
                            </form>
                        </div>
                    </template>
                </div>

                {{-- Grid of pending media --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    @foreach($pending as $media)
                        <div class="relative bg-white rounded shadow-sm overflow-hidden group" data-media-id="{{ $media->id }}">
                            {{-- Checkbox --}}
                            <label class="absolute top-2 left-2 z-10 cursor-pointer">
                                <input type="checkbox" value="{{ $media->id }}" x-model="selected" class="rounded border-slate-400 shadow" />
                            </label>

                            {{-- Thumbnail --}}
                            <div class="aspect-[4/3] bg-slate-200 cursor-pointer"
                                 @click="openPreview({
                                    id: {{ $media->id }},
                                    thumb: '{{ $media->thumbnail_path ? asset('storage/' . $media->thumbnail_path) : '' }}',
                                    full: '{{ $media->path ? asset('storage/' . $media->path) : '' }}',
                                    legend: '{{ addslashes($media->legend ?? '') }}',
                                    user: '{{ addslashes($media->user?->name ?? 'Unknown') }}',
                                    event: '{{ addslashes($media->event?->name ?? 'Unknown') }}',
                                    date: '{{ $media->created_at->format('Y-m-d H:i') }}'
                                 })">
                                @if($media->thumbnail_path)
                                    <img src="{{ asset('storage/' . $media->thumbnail_path) }}" alt="{{ $media->legend ?? 'Pending photo' }}" class="w-full h-full object-cover" loading="lazy" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 text-3xl">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Info + actions --}}
                            <div class="p-2">
                                <div class="text-xs text-slate-500 truncate">{{ $media->user?->name ?? 'Unknown' }}</div>
                                <div class="text-xs text-slate-400 truncate">{{ $media->event?->name ?? '' }}</div>
                                <div class="flex gap-2 mt-2">
                                    <form method="POST" action="{{ route('management.media.approve', $media) }}" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full text-center text-xs uppercase font-bold tracking-widest text-green-600 hover:text-green-500 transition-all py-1">
                                            <i class="fa-solid fa-check"></i> Accept
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('management.media.refuse', $media) }}" class="flex-1"
                                          onsubmit="return confirm('Refuse this photo? The original file will be deleted.')">
                                        @csrf
                                        <button type="submit" class="w-full text-center text-xs uppercase font-bold tracking-widest text-red-500 hover:text-red-400 transition-all py-1">
                                            <i class="fa-solid fa-xmark"></i> Refuse
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-24">
                    <div class="text-4xl text-slate-300 mb-4"><i class="fa-solid fa-inbox"></i></div>
                    <div class="text-2xl text-slate-400 uppercase font-bold -tracking-[0.04em]">Inbox empty</div>
                    <div class="text-sm text-slate-300 uppercase tracking-widest mt-1">No pending media to review</div>
                </div>
            @endif

            {{-- Preview overlay --}}
            <div x-show="preview" x-transition
                 class="fixed inset-0 bg-slate-800/95 z-50 flex items-center justify-center p-4"
                 @click.self="closePreview()" @keydown.escape.window="closePreview()"
                 style="display: none;">
                <div class="bg-white rounded shadow-lg max-w-3xl w-full max-h-[90vh] overflow-y-auto" @click.stop>
                    <template x-if="preview">
                        <div>
                            <div class="bg-slate-700 text-white p-4 flex items-center justify-between">
                                <div class="text-sm uppercase tracking-widest font-bold" x-text="preview.event"></div>
                                <button @click="closePreview()" class="text-white text-xl hover:text-slate-300">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <div class="p-4">
                                <img :src="preview.full || preview.thumb" class="w-full max-h-[60vh] object-contain bg-slate-100 rounded mb-4" />
                                <div class="flex flex-col gap-1 text-sm text-slate-600 mb-4">
                                    <div><span class="uppercase tracking-widest text-slate-400 font-bold">By</span> <span x-text="preview.user"></span></div>
                                    <div><span class="uppercase tracking-widest text-slate-400 font-bold">Date</span> <span x-text="preview.date"></span></div>
                                    <div x-show="preview.legend"><span class="uppercase tracking-widest text-slate-400 font-bold">Legend</span> <span x-text="preview.legend"></span></div>
                                </div>
                                <div class="flex gap-3">
                                    <form method="POST" :action="'{{ url('/management/media') }}/' + preview.id + '/approve'">
                                        @csrf
                                        <button type="submit" class="btn btn-success text-lg">
                                            <i class="fa-solid fa-check mr-1"></i>Accept
                                        </button>
                                    </form>
                                    <form method="POST" :action="'{{ url('/management/media') }}/' + preview.id + '/refuse'"
                                          onsubmit="return confirm('Refuse this photo? The original file will be deleted.')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger text-lg">
                                            <i class="fa-solid fa-xmark mr-1"></i>Refuse
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </main>
</x-layouts.public>
