{{--
    Media index — full-page gallery with lightbox.
    Same structure as the media section on the top page.
    When ?event=slug is active, shows a filter bar with event name + link back to full gallery.
--}}

<x-layouts.public
    :menuBack="['url' => url('/#media'), 'label' => 'Back']"
    :title="($filteredEvent ? $filteredEvent->name . ' — ' : '') . 'Media — GoGoGo'">

    <main class="top relative h-screen snap-y snap-mandatory overflow-y-auto scroll-smooth">
        <section id="media" class="top-section bg-slate-700 flex flex-col">
            <x-front.section-header bg="bg-white" text="text-slate-700">Media</x-front.section-header>

            @if($filteredEvent)
                {{-- Filter indicator --}}
                <div class="flex-none px-4 md:px-8 lg:px-16 pt-4">
                    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
                        <div class="text-white text-sm md:text-base uppercase tracking-widest font-bold truncate">
                            <i class="fa-solid fa-filter fa-fw mr-1 text-slate-400"></i>
                            {{ $filteredEvent->name }}
                        </div>
                        <a href="{{ route('media.index') }}" class="btn btn-main text-base whitespace-nowrap">
                            <i class="fa-solid fa-xmark fa-fw mr-1"></i>See all
                        </a>
                    </div>
                </div>
            @else
                <x-front.diagonal-nav href="/media" color="blue" label="See all" />
            @endif

            <x-front.media-gallery :photos="$photos" />
        </section>
    </main>
</x-layouts.public>
