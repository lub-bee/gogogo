{{--
    Media index — full-page gallery with lightbox.
    Same structure as the media section on the top page.
--}}

<x-layouts.public
    :menuBack="['url' => url('/#media'), 'label' => 'Back']"
    title="Media — GoGoGo">

    <main class="top relative h-screen snap-y snap-mandatory overflow-y-auto scroll-smooth">
        <section id="media" class="top-section bg-slate-700 flex flex-col">
            <x-front.section-header bg="bg-white" text="text-slate-700">Media</x-front.section-header>

            <x-front.diagonal-nav href="/media" color="blue" label="See all" />

            <x-front.media-gallery :photos="$photos" />
        </section>
    </main>
</x-layouts.public>
