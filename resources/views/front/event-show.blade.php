{{--
    Event show page — single event detail with Prev/Next navigation.
--}}
@props([
    'event' => [
        'name' => 'Gogogo at The Mall',
        'slug' => 'gogogo-at-the-mall',
        'type' => 'gogogo',
        'start_at' => '2024-09-22 14:00:00',
        'end_at' => '2024-09-22 16:00:00',
        'description_en' => '<h2>Let\'s meet at the mall!</h2><p>Join us for our weekly language exchange session.</p><ul><li>Meeting point: main entrance</li><li>Start: 14:00</li><li>Fee: free</li></ul>',
        'description_ja' => '<h2>モールで会いましょう！</h2><p>毎週の言語交換セッションにぜひご参加ください。</p><ul><li>集合場所：正面入口</li><li>開始：14:00</li><li>参加費：無料</li></ul>',
        'published_at' => '2024-09-20',
    ],
    'prevEventUrl' => '/event/prev-placeholder',
    'nextEventUrl' => null,
])

@php
    $startAt = \Carbon\Carbon::parse($event['start_at'] ?? now());
@endphp

<x-layouts.public
    :menuBack="['url' => url('/#event'), 'label' => 'Back']"
    :title="($event['name'] ?? 'Event') . ' — GoGoGo'">

    <main class="top relative h-screen snap-y snap-mandatory overflow-y-auto scroll-smooth">
        <section id="event" class="top-section flex flex-col bg-white relative">
            <x-front.section-header bg="bg-slate-700" text="text-white">event</x-front.section-header>

            <x-front.event-nav :prevUrl="$prevEventUrl" :nextUrl="$nextEventUrl" />

            <main class="flex-1 mt-4 md:mt-0 h-full flex flex-col md:flex-row items-center justify-evenly">
                <div class="md:h-full md:w-auto flex flex-row md:flex-col justify-evenly items-center">
                    <x-front.calendar-card
                        :year="$startAt->format('Y')"
                        :day="$startAt->format('d')"
                        :month="$startAt->format('M')" />

                    <div class="text-[1.3rem] sm:text-[2rem] flex flex-col h-full md:h-[25vh]">
                        <div class="flex-1 flex items-center gap-4 group cursor-pointer">
                            <i class="fa-solid fa-images fa-fw"></i>
                            <div class="bg-sky-200 leading-5 hover:bg-orange-200 transition-all">Media</div>
                        </div>
                        <div class="flex-1 flex items-center gap-4 group cursor-pointer">
                            <i class="fa-solid fa-file-alt fa-fw"></i>
                            <div class="bg-sky-200 leading-5 hover:bg-orange-200 transition-all">Topic</div>
                        </div>
                        <div class="flex-1 flex items-center gap-4 group cursor-pointer">
                            <i class="fa-solid fa-location-dot fa-fw"></i>
                            <div class="bg-sky-200 leading-5 hover:bg-orange-200 transition-all">Location</div>
                        </div>
                        <div class="flex-1 flex items-center gap-4 group cursor-pointer">
                            <i class="fa-solid fa-person-walking-luggage"></i>
                            <div class="bg-sky-200 leading-5 hover:bg-yellow-200 transition-all">I'm going</div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-2/4">
                    <div class="xs:mt-4 px-4 lg:px-0 text-[2.5rem] xl:text-[5rem] leading-[2.5rem] xl:leading-[5rem] lg:tracking-tight font-bold uppercase">
                        {{ $event['name'] }}
                    </div>
                    <div class="px-4 lg:px-0 mt-4 lg:hover:scale-105 lg:text-lg transition-all max-h-[18vh] md:h-[30vh] overflow-y-scroll formated-content">
                        {!! $event['description_en'] !!}
                    </div>
                    <div class="px-4 lg:px-0 mt-4 lg:hover:scale-105 lg:text-lg transition-all max-h-[18vh] md:h-[30vh] overflow-y-scroll formated-content">
                        {!! $event['description_ja'] !!}
                    </div>
                </div>
            </main>
        </section>
    </main>
</x-layouts.public>
