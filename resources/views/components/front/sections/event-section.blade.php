<header class='bg-slate-700 text-white'>
    event
</header>

<x-event.event-navigation />

<main class="flex-1 mt-4 md:mt-0 h-full flex flex-col md:flex-row items-center justify-evenly" :class="mode === 'default' ? '' : 'hidden'">
    <div class=' md:h-full md:w-auto flex flex-row md:flex-col justify-evenly items-center'>
        <x-event.calendar-card year="2024" month="mar" day="22"/>
        <x-event.responsive-related-card/>
    </div>
    <x-event.event-info-card/>
</main>
