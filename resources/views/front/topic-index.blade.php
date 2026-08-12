{{--
    Topic index — all published topics in accordion style.
--}}

<x-layouts.public
    :menuBack="['url' => url('/#topic'), 'label' => 'Back']"
    title="Topics — GoGoGo">

    <div class="min-h-screen bg-white text-slate-700">
        <div class="top">
            <x-front.section-header bg="bg-slate-200" text="text-slate-700">Topics</x-front.section-header>
        </div>

        <main class="max-w-6xl mx-auto px-4 md:px-8 py-8">
            @if($topics->count() > 0)
                <x-front.topic-accordion :topics="$topics->map(fn ($t) => [
                    'name' => $t->name,
                    'slug' => $t->slug,
                    'description_en' => $t->description_en,
                    'description_ja' => $t->description_ja,
                    'published_at' => $t->published_at?->format('Y-m-d'),
                ])->all()" />

                <div class="mt-8">
                    {{ $topics->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="text-2xl text-slate-400 uppercase font-light">No topics published yet</div>
                    <div class="text-lg text-slate-300 mt-2">まだトピックが公開されていません</div>
                </div>
            @endif
        </main>
    </div>
</x-layouts.public>
