<x-public-layout>

    <div class="h-screen flex flex-col">
        <header class='bg-slate-700 text-white'>
            event
        </header>

        <x-event.event-navigation />


        <main class="flex-1 mt-4 md:mt-0 h-full flex flex-col md:flex-row items-center justify-evenly" :class="mode === 'default' ? '' : 'hidden'">
            <div class=' md:h-full md:w-auto flex flex-row md:flex-col justify-evenly items-center'>
                <x-event.calendar-card :year="$event->start_at->format('Y')" :month="$event->start_at->format('M')" :day="$event->start_at->format('d')"/>
                <x-event.responsive-related-card  media_id="1" topic_id="2" location_id="3"/>
            </div>
            <x-event.event-info-card :event="$event"/>
        </main>

    </div>






    {{-- TRASH --}}

    {{-- <div class='info'>
        {{$event->name}}<br>
    </div>

    <div class='info'>
        {{$event->slug}}<br>
    </div>

    <div class='info'>
        {{$event->start_at}}<br>
    </div>

    <div class='info'>
        {{$event->end_at}}<br>
    </div>

    <div class='info'>
        {{$event->cost}}<br>
    </div>

    <div class='info'>
        {{$event->topic->description_en}}<br>
    </div> --}}


    {{-- TODO Add date, day, month, year separately --}}
    {{-- <div class='info'>
        {{$event->start_at}}<br>
    </div> --}}

    {{-- TODO Add Topic ID --}}
    {{-- <div class='info'>
        {{$event->topic_id}}<br>
    </div> --}}

    {{-- TODO Add Location ID --}}
    {{-- <div class='info'>
        {{$event->location_id}}<br>
    </div> --}}

    {{-- TODO Add Content (Description En) Separate --}}
    {{-- <div class='info'>
        {{$event->description_en}}<br>
    </div> --}}

    {{-- TODO Add Content (Description JA) Separate --}}
    {{-- <div class='info'>
        {{$event->description_ja}}<br>
    </div> --}}

    {{-- TODO Add PREV button link WITH LUDO --}}
    {{-- <div class='info'>

    </div> --}}

    {{-- TODO Add NEXT button link WITH LUDO --}}
    {{-- <div class='info'>

    </div> --}}

</x-public-layout>
