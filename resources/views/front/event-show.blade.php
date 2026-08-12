{{--
    Event show page — single event detail with Prev/Next navigation.
--}}

@php
    $startAt = $event->start_at ?? now();
@endphp

<x-layouts.public
    :menuBack="['url' => url('/#event'), 'label' => 'Back']"
    :title="$event->name . ' — GoGoGo'">

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
                        @if($event->topic)
                        <a href="{{ route('topic.show', $event->topic) }}" class="flex-1 flex items-center gap-4 group cursor-pointer">
                            <i class="fa-solid fa-file-alt fa-fw"></i>
                            <div class="bg-sky-200 leading-5 hover:bg-orange-200 transition-all">Topic</div>
                        </a>
                        @endif
                        @if($event->location)
                        <a href="{{ route('location.show', $event->location) }}" class="flex-1 flex items-center gap-4 group cursor-pointer">
                            <i class="fa-solid fa-location-dot fa-fw"></i>
                            <div class="bg-sky-200 leading-5 hover:bg-orange-200 transition-all">Location</div>
                        </a>
                        @endif
                        <div class="flex-1 flex items-center gap-4 group cursor-pointer">
                            <i class="fa-solid fa-images fa-fw"></i>
                            <div class="bg-sky-200 leading-5 hover:bg-orange-200 transition-all">Media</div>
                        </div>
                        @auth
                        <form method="POST" action="{{ route('event.rsvp', $event) }}" class="flex-1 flex items-center">
                            @csrf
                            <button type="submit" class="flex items-center gap-4 group cursor-pointer">
                                <i class="fa-solid fa-person-walking-luggage"></i>
                                <div class="{{ $isAttending ? 'bg-yellow-200' : 'bg-sky-200' }} leading-5 hover:bg-yellow-200 transition-all">
                                    {{ $isAttending ? "I'm going!" : "I'm going" }}
                                </div>
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="flex-1 flex items-center gap-4 group cursor-pointer">
                            <i class="fa-solid fa-person-walking-luggage"></i>
                            <div class="bg-sky-200 leading-5 hover:bg-yellow-200 transition-all">I'm going</div>
                        </a>
                        @endauth
                    </div>
                </div>

                <div class="w-full md:w-2/4">
                    <div class="xs:mt-4 px-4 lg:px-0 text-[2.5rem] xl:text-[5rem] leading-[2.5rem] xl:leading-[5rem] lg:tracking-tight font-bold uppercase">
                        {{ $event->name }}
                    </div>
                    <div class="px-4 lg:px-0 mt-4 lg:hover:scale-105 lg:text-lg transition-all max-h-[18vh] md:h-[30vh] overflow-y-scroll formatted-content">
                        {!! $event->description_en !!}
                    </div>
                    <div class="px-4 lg:px-0 mt-4 lg:hover:scale-105 lg:text-lg transition-all max-h-[18vh] md:h-[30vh] overflow-y-scroll formatted-content">
                        {!! $event->description_ja !!}
                    </div>
                </div>
            </main>
        </section>
    </main>
</x-layouts.public>
