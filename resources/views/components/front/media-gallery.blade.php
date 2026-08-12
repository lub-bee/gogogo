{{--
    Media gallery strip — horizontally scrollable photo tiles with hover title/date and lightbox.
    Usage: <x-front.media-gallery :photos="$photos" />

    Each photo: ['title', 'date', 'width', 'height', 'bg', 'icon']
--}}
@props([
    'photos' => [
        ['title' => 'Gogogo at The Mall', 'date' => '22 SEP 2024', 'width' => 280, 'height' => 200, 'bg' => 'rgb(100 116 139)', 'icon' => 'fa-image'],
        ['title' => 'Badminton night!', 'date' => '25 SEP 2024', 'width' => 160, 'height' => 240, 'bg' => 'linear-gradient(135deg, rgb(51 65 85), rgb(30 41 59))', 'icon' => 'fa-camera'],
        ['title' => 'Gogogo at The Mall', 'date' => '22 SEP 2024', 'width' => 320, 'height' => 180, 'bg' => 'rgb(71 85 105)', 'icon' => 'fa-image'],
        ['title' => 'Trip to Matsushima', 'date' => '07 OCT 2024', 'width' => 170, 'height' => 260, 'bg' => 'linear-gradient(to bottom, rgb(71 85 105), rgb(51 65 85))', 'icon' => 'fa-camera'],
        ['title' => 'Oktoberfest at Nichikichou', 'date' => '29 SEP 2024', 'width' => 260, 'height' => 190, 'bg' => 'rgb(30 41 59)', 'icon' => 'fa-image'],
        ['title' => 'Badminton night!', 'date' => '25 SEP 2024', 'width' => 210, 'height' => 210, 'bg' => 'rgb(51 65 85)', 'icon' => 'fa-image'],
        ['title' => 'Trip to Matsushima', 'date' => '07 OCT 2024', 'width' => 300, 'height' => 200, 'bg' => 'linear-gradient(to right, rgb(100 116 139), rgb(71 85 105))', 'icon' => 'fa-image'],
        ['title' => 'Gogogo at The Mall', 'date' => '22 SEP 2024', 'width' => 150, 'height' => 230, 'bg' => 'rgb(100 116 139 / 0.8)', 'icon' => 'fa-camera'],
        ['title' => 'Oktoberfest at Nichikichou', 'date' => '29 SEP 2024', 'width' => 270, 'height' => 180, 'bg' => 'linear-gradient(135deg, rgb(30 41 59), rgb(71 85 105))', 'icon' => 'fa-image'],
        ['title' => 'Badminton night!', 'date' => '25 SEP 2024', 'width' => 140, 'height' => 250, 'bg' => 'rgb(71 85 105)', 'icon' => 'fa-camera'],
    ],
])

<div x-data="{
    activeTitle: '', activeDate: '', displayTitle: '', displayDate: '',
    titleVisible: false, exitTimer: null,
    expanded: false, expandTitle: '', expandDate: '', expandBg: '', photoEntered: false,
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
    openPhoto(title, date, bg) {
        this.expanded = true; this.expandTitle = title; this.expandDate = date; this.expandBg = bg;
        this.displayTitle = title; this.displayDate = date; this.titleVisible = true;
        this.photoEntered = false;
        this.$nextTick(() => { this.photoEntered = true; });
    },
    closePhoto() {
        this.photoEntered = false;
        setTimeout(() => {
            this.expanded = false; this.expandTitle = ''; this.expandDate = ''; this.expandBg = '';
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
                @foreach($photos as $photo)
                    <div class="photo-tile"
                         style="width: {{ $photo['width'] }}px; height: {{ $photo['height'] }}px; background: {{ $photo['bg'] }};"
                         @mouseenter="showTitle('{{ addslashes($photo['title']) }}', '{{ $photo['date'] }}')"
                         @mouseleave="hideTitle()"
                         @click="openPhoto('{{ addslashes($photo['title']) }}', '{{ $photo['date'] }}', '{{ addslashes($photo['bg']) }}')">
                        <div class="tile-icon"><i class="fa-solid {{ $photo['icon'] }}"></i></div>
                    </div>
                @endforeach
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
                <div class="media-lightbox-photo"
                     :style="'width: 70vw; height: 60vh; background: ' + expandBg + '; transform: scale(' + (photoEntered ? '1' : '0.7') + '); opacity: ' + (photoEntered ? '0.2' : '0')"
                     @click.stop>
                    <i class="fa-solid fa-image"></i>
                </div>
            </div>
        </div>
    </div>
</div>
