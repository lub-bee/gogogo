<header class='bg-slate-700 text-white'>
    event
</header>

<x-event.event-navigation />

<main class="flex-1 mt-4 md:mt-0 h-full flex flex-col md:flex-row items-center justify-evenly" :class="mode === 'default' ? '' : 'hidden'">
    <div class=' md:h-full md:w-auto flex flex-row md:flex-col justify-evenly items-center'>
        <x-event.calendar-card year="{{$event->start_at->format('Y')}}" month="{{$event->start_at->format('M')}}" day="{{$event->start_at->format('d')}}"/>
        <x-event.responsive-related-card media_id="1" topic_id="2" location_id="3"/>
    </div>
    <x-event.event-info-card/>
</main>
