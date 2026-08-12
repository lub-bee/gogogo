{{--
    Media gallery strip — horizontally scrollable photo tiles with hover title/date and lightbox.
    Usage: <x-front.media-gallery :photos="$photos" />

    Each photo: ['title', 'date', 'thumb', 'full', 'legend']
    - thumb: URL to thumbnail image (or null for placeholder)
    - full: URL to full-size image (or null)
--}}
@props([
    'photos' => [],
])

<div x-data="{
    activeTitle: '', activeDate: '', displayTitle: '', displayDate: '',
    titleVisible: false, exitTimer: null,
    expanded: false, expandTitle: '', expandDate: '', expandSrc: '', photoEntered: false,
    showTitle(title, date) {
        clearTimeout(this.exitTimer);
        this.activeTitle = title; this.activeDate = date;
        this.displayTitle = title; this.displayDate = date;
        this.titleVisible = true;
    },
    hideTitle() {
        this.activeTitle = ''; this.activeDate = '';
        this.exitTimer = setTimeout(() => {
            if (!this.activeTitle && !this.expandTitle) {
                this.titleVisible = false;
                setTimeout(() => {
                    if (!this.activeTitle && !this.expandTitle) {
                        this.displayTitle = ''; this.displayDate = '';
                    }
                }, 400);
            }
        }, 80);
    },
    get currentTitle() { return this.expandTitle || this.displayTitle || ' '; },
    get currentDate() { return this.expandDate || this.displayDate || ' '; },
    get isVisible() { return this.titleVisible || !!this.expandTitle; },
    openPhoto(title, date, src) {
        this.expanded = true; this.expandTitle = title; this.expandDate = date; this.expandSrc = src;
        this.displayTitle = title; this.displayDate = date; this.titleVisible = true;
        this.photoEntered = false;
        this.$nextTick(() => { this.photoEntered = true; });
    },
    closePhoto() {
        this.photoEntered = false;
        setTimeout(() => {
            this.expanded = false; this.expandTitle = ''; this.expandDate = ''; this.expandSrc = '';
            if (!this.activeTitle) {
                this.titleVisible = false;
                setTimeout(() => {
                    if (!this.activeTitle) { this.displayTitle = ''; this.displayDate = ''; }
                }, 400);
            }
        }, 300);
    }
}">

    {{-- Title + date zone --}}
    <div class="flex-none px-4 md:px-8 lg:px-16 pt-6 pb-2 overflow-hidden" style="min-height: 5.5rem;">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-baseline md:justify-between gap-1">
            <div class="media-title-text font-bold text-[2rem] sm:text-[3rem] lg:text-[4.5rem] leading-[1.8rem] sm:leading-[2.8rem] lg:leading-[4rem] uppercase text-white"
                 :style="'letter-spacing: ' + (isVisible ? '-0.04em' : '-0.12em') + '; opacity: ' + (isVisible ? '1' : '0')"
                 x-text="currentTitle"></div>
            <div class="media-date-text text-slate-400 text-lg sm:text-xl lg:text-2xl font-bold uppercase text-right"
                 :style="'letter-spacing: ' + (isVisible ? '0.15em' : '0.05em') + '; opacity: ' + (isVisible ? '1' : '0')"
                 x-text="currentDate"></div>
        </div>
    </div>

    {{-- Gallery strip --}}
    <div class="flex-1 flex flex-col justify-center px-4 md:px-8 lg:px-16 relative overflow-hidden">
        <div class="max-w-7xl mx-auto w-full">
            <div class="gallery-strip">
                @forelse($photos as $photo)
                    <div class="photo-tile"
                         style="width: 260px; height: 200px; background: rgb(71 85 105);"
                         @mouseenter="showTitle('{{ addslashes($photo['title']) }}', '{{ $photo['date'] }}')"
                         @mouseleave="hideTitle()"
                         @click="openPhoto('{{ addslashes($photo['title']) }}', '{{ $photo['date'] }}', '{{ $photo['full'] ?? '' }}')">
                        @if($photo['thumb'])
                            <img src="{{ $photo['thumb'] }}" alt="{{ $photo['title'] }}" class="w-full h-full object-cover" loading="lazy" />
                        @else
                            <div class="tile-icon"><i class="fa-solid fa-image"></i></div>
                        @endif
                    </div>
                @empty
                    <div class="flex items-center justify-center w-full py-8">
                        <div class="text-xl text-slate-400 uppercase font-light">No photos yet</div>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Lightbox --}}
        <div class="media-lightbox-overlay"
             x-show="expanded"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             @click.self="closePhoto()"
             style="display: none;">
            <div class="media-lightbox-inner">
                <div class="media-lightbox-close" @click="closePhoto()">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <template x-if="expandSrc">
                    <img :src="expandSrc"
                         class="media-lightbox-photo max-w-[85vw] max-h-[85vh] object-contain"
                         :style="'transform: scale(' + (photoEntered ? '1' : '0.7') + '); opacity: ' + (photoEntered ? '1' : '0')"
                         @click.stop />
                </template>
                <template x-if="!expandSrc">
                    <div class="media-lightbox-photo"
                         style="width: 70vw; height: 60vh;"
                         :style="'background: rgb(71 85 105); transform: scale(' + (photoEntered ? '1' : '0.7') + '); opacity: ' + (photoEntered ? '0.2' : '0')"
                         @click.stop>
                        <i class="fa-solid fa-image"></i>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
