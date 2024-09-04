<x-public-layout>

    <x-front.section id="top" class="bg-white flex flex-col">
        <x-front.sections.top-section :greetings="$greetings"/>
    </x-front.section>

    <x-front.section id="event" class="flex flex-col bg-white relative">
        <x-front.sections.event-section :event="$event"/>
    </x-front.section>

    <x-front.section id="agenda" class="bg-slate-700 text-white flex flex-col">
        <x-front.sections.agenda-section />
    </x-front.section>

    <x-front.section id="about" class="bg-slate-200 flex flex-col">
        <x-front.sections.about-section />
    </x-front.section>

    <x-front.section id="media" class="bg-slate-600">
        <x-front.sections.media-section />
    </x-front.section>

    <x-front.section id="topic" class="bg-blue-200">
        <x-front.sections.topic-section />
    </x-front.section>

</x-public-layout>
