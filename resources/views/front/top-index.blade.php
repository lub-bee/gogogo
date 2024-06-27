<x-public-layout>

    <x-front.section id="top" class="bg-white">
        Top
    </x-front.section>

    <x-front.section id="event" class="flex flex-col relative bg-white">
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

    </x-front.section>

    <x-front.section id="agenda" class="bg-slate-700 text-white flex flex-col">
        <header class='bg-white text-slate-700'>
            Agenda
        </header>

        <div class='flex-1 max-w-5xl mx-auto flex flex-col justify-evenly'>
            <div class='flex gap-14'>
                <div class='text-right flex-none w-1/4 font-bold text-[3rem] sm:text-[4.5rem] lg:text-[7rem] leading-[2rem] sm:leading-[3rem] lg:leading-[6rem] -tracking-[0.12em]'>
                    SEPT
                </div>
                <div class='font-bold text-[2rem] sm:text-[2.5rem] leading-[2rem] sm:leading-[4.5rem] divide-y-4'>
                    <x-front.event.event-agenda-tile date="22" title="Gogogo at The Mall"/>
                    <x-front.event.event-agenda-tile date="25" title="Badminton night!"/>
                    <x-front.event.event-agenda-tile date="29" title="Oktoberfes at Nichikichou Koen"/>
                </div>
            </div>

            <div class='flex gap-14'>
                <div class='text-right flex-none w-1/4 font-bold text-[3rem] sm:text-[4.5rem] lg:text-[7rem] leading-[2rem] sm:leading-[3rem] lg:leading-[6rem] -tracking-[0.12em]'>
                    OCT
                </div>
                <div class=' font-bold text-[2rem] sm:text-[2.5rem] leading-[2rem] sm:leading-[4.5rem] divide-y-4'>
                    <x-front.event.event-agenda-tile date="07" title="Trip to Matsushima"/>
                    <x-front.event.event-agenda-tile date="12" title="Gogogo Friday"/>
                    <x-front.event.event-agenda-tile date="17" title="Beer garden"/>
                </div>

            </div>

            <div class='text-center my-10'>
                <a href="{{ route('front.agenda.index') }}" class='btn btn-main' >
                    See all
                </a>
            </div>
        </div>



    </x-front.section>

    <x-front.section id="about" class="bg-yellow-200">
        <header class='bg-slate-700 text-yellow-200'>
            About
        </header>
    </x-front.section>

    <x-front.section id="topic" class="bg-slate-700">
        <header class='bg-yellow-200 text-slate-700'>
            Topic
        </header>
    </x-front.section>

    <x-front.section id="media" class="bg-blue-200">
        <header class='bg-slate-700 text-blue-200'>
            Media
        </header>
    </x-front.section>

</x-public-layout>
