@props(['event'])

<x-event.event-navigation />

 {{-- {{$event->name}}<br>
    {{$event->slug}}<br>
    {{$event->start_at}}<br>
    {{$event->end_at}}<br>
    {{$event->description_en}}<br>
    {{$event->description_ja}}<br>
    {{$event->cost}}<br> --}}

<main class="flex-1 mt-4 md:mt-0 h-full flex flex-col md:flex-row items-center justify-evenly" :class="mode === 'default' ? '' : 'hidden'">
    <div class=' md:h-full md:w-auto flex flex-row md:flex-col justify-evenly items-center'>
        <x-event.calendar-card
            year="{{ $event->start_at->format('Y') }}"
            month="{{ $event->start_at->format('M') }}"
            day="{{ $event->start_at->format('d') }}"
        />

        <x-event.responsive-related-card :event="$event"/>
    </div>

    <x-event.event-info-card :event="$event"/>
</main>
