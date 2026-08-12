{{--
    Location show — venue title, map, upcoming/past event lists.
--}}

@php
    $lat = $location->gps_lat ?? 38.2630;
    $lng = $location->gps_lng ?? 140.8750;
    $bbox = ($lng - 0.01) . '%2C' . ($lat - 0.005) . '%2C' . ($lng + 0.01) . '%2C' . ($lat + 0.005);
@endphp

<x-layouts.public
    :menuBack="['url' => url('/#location'), 'label' => 'Back']"
    :title="$location->name . ' — GoGoGo'">

    <main class="top relative h-screen snap-y snap-mandatory overflow-y-auto scroll-smooth">
        <section id="location" class="top-section bg-slate-200 flex flex-col">
            <x-front.section-header bg="bg-slate-700" text="text-white">Location</x-front.section-header>

            <div class="flex-1 min-h-0 max-w-6xl mx-auto flex flex-col gap-6 w-full px-4 py-8 justify-start overflow-y-auto">

                {{-- Location name --}}
                <div class="text-[calc(2.5rem-2px)] xl:text-[calc(5rem-2px)] leading-[2.5rem] xl:leading-[5rem] lg:tracking-tight font-bold uppercase overflow-hidden ls-title">
                    {{ $location->name }}
                </div>

                <div class="flex flex-col lg:flex-row gap-8 lg:gap-14 items-start flex-1">

                    {{-- LEFT: map + address --}}
                    <div class="w-full lg:w-[38%] flex flex-col gap-4 flex-shrink-0">
                        @if($lat && $lng)
                        <div class="ls-map-wrap w-full aspect-[4/3] overflow-hidden">
                            <iframe
                                width="100%" height="100%" frameborder="0" scrolling="no"
                                marginheight="0" marginwidth="0"
                                style="border:0; background-color: #334155;"
                                src="https://www.openstreetmap.org/export/embed.html?bbox={{ $bbox }}&layer=mapnik&marker={{ $lat }}%2C{{ $lng }}"
                                loading="lazy"
                                title="Location map — {{ $location->name }}"></iframe>
                        </div>
                        @endif

                        <div class="flex flex-col gap-1">
                            <div class="text-lg md:text-xl uppercase font-bold -tracking-[0.08em]">
                                {{ $location->description_en ?? '' }}
                            </div>
                            <div class="text-base md:text-lg uppercase text-slate-500">
                                {{ $location->description_ja ?? '' }}
                            </div>
                            @if($location->website_url)
                            <a href="{{ $location->website_url }}" target="_blank" class="text-blue-600 hover:underline text-sm mt-1">
                                <i class="fa-solid fa-external-link fa-fw"></i> Website
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- RIGHT: events at this location --}}
                    <div class="w-full lg:flex-1 flex flex-col gap-4 overflow-y-auto max-h-[65vh]">
                        @if(count($upcomingEvents) > 0 || count($pastEvents) > 0)
                            <div class="text-[2rem] sm:text-[2.5rem] leading-[3rem] sm:leading-[4.5rem] flex flex-col divide-y lg:divide-y-4 divide-slate-700">

                                @if(count($upcomingEvents) > 0)
                                    <div class="text-xs uppercase tracking-widest text-slate-500 pt-2 pb-1 font-bold">Upcoming</div>
                                    @foreach($upcomingEvents as $evt)
                                        <a class="flex gap-8 group" href="{{ url('/event/' . $evt['slug']) }}">
                                            <div class="ls-date font-bold tracking-widest whitespace-nowrap">{{ $evt['date'] }}</div>
                                            <div><i class="fas {{ $evt['icon'] }} fa-fw"></i></div>
                                            <div class="-tracking-[0.08em] font-light group-hover:tracking-tight transition-all whitespace-nowrap">{{ $evt['title'] }}</div>
                                        </a>
                                    @endforeach
                                @endif

                                @if(count($pastEvents) > 0)
                                    <div class="ls-section-label text-xs uppercase tracking-widest text-slate-500 pt-4 pb-1 font-bold">Past</div>
                                    @foreach($pastEvents as $evt)
                                        <a class="flex gap-8 group text-slate-500" href="{{ url('/event/' . $evt['slug']) }}">
                                            <div class="ls-date font-bold tracking-widest whitespace-nowrap">{{ $evt['date'] }}</div>
                                            <div><i class="fas {{ $evt['icon'] }} fa-fw"></i></div>
                                            <div class="-tracking-[0.08em] font-light group-hover:tracking-tight transition-all whitespace-nowrap">{{ $evt['title'] }}</div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        @else
                            <div class="flex flex-col items-start gap-2 py-8">
                                <div class="text-xl md:text-2xl uppercase font-light -tracking-[0.08em] text-slate-600">
                                    No event has taken place here yet.
                                </div>
                                <div class="text-lg md:text-xl uppercase font-light text-slate-500">
                                    ここではまだイベントが開催されていません。
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts.public>
