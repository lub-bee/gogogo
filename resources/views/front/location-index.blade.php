{{--
    Location index — all venues ordered by event count.
--}}

<x-layouts.public
    :menuBack="['url' => url('/#location'), 'label' => 'Back']"
    title="Locations — GoGoGo">

    <div class="min-h-screen bg-slate-200 text-slate-700">
        <div class="top">
            <x-front.section-header bg="bg-slate-700" text="text-white">Locations</x-front.section-header>
        </div>

        <main class="max-w-6xl mx-auto px-4 md:px-8 py-8">
            @if(count($locations) > 0)
                @foreach($locations as $loc)
                    <x-front.location-row
                        :icon="$loc['icon']"
                        :name="$loc['name']"
                        :count="$loc['count']"
                        :href="url('/location/' . ($loc['slug'] ?? '#'))" />
                @endforeach
            @else
                <div class="text-center py-16">
                    <div class="text-2xl text-slate-400 uppercase font-light">No locations yet</div>
                    <div class="text-lg text-slate-300 mt-2">まだ場所が登録されていません</div>
                </div>
            @endif
        </main>
    </div>
</x-layouts.public>
