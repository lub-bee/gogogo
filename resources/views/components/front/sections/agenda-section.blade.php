<header class='bg-white text-slate-700'>
    Agenda
</header>

<div class='flex-1 max-w-6xl mx-auto flex flex-col justify-evenly'>
    <div class='flex flex-col lg:flex-row gap-4 lg:gap-14'>
        <div class='lg:text-right flex-none lg:w-1/4 font-bold text-[3rem] sm:text-[4.5rem] lg:text-[7rem] leading-[2rem] md:leading-[3rem] lg:leading-[6rem] -tracking-[0.12em]'>
            SEPT
        </div>
        <div class='flex-1 text-[2rem] sm:text-[2.5rem] leading-[3rem] sm:leading-[4.5rem] divide-y lg:divide-y-4'>
            <x-front.event.event-agenda-tile date="22" title="Gogogo at The Mall" slug="2024-9-22"/>
            <x-front.event.event-agenda-tile date="25" title="Badminton night!" slug="2024-9-25" icon="fas fa-mug-hot"/>
            <x-front.event.event-agenda-tile date="29" title="Oktoberfes at Nichikichou Koen" slug="2024-9-29" icon="fas fa-mug-hot"/>
        </div>
    </div>

    <div class='flex flex-col lg:flex-row gap-4 lg:gap-14'>
        <div class='lg:text-right flex-none lg:w-1/4 font-bold text-[3rem] sm:text-[4.5rem] lg:text-[7rem] leading-[2rem] sm:leading-[3rem] lg:leading-[6rem] -tracking-[0.12em]'>
            OCT
        </div>
        <div class='flex-1 font-bold text-[2rem] sm:text-[2.5rem] leading-[3rem] sm:leading-[4.5rem] divide-y lg:divide-y-4'>
            <x-front.event.event-agenda-tile date="07" title="Trip to Matsushima" slug="2024-10-07" icon="fas fa-mug-hot"/>
            <x-front.event.event-agenda-tile date="12" title="Gogogo Friday" slug="2024-10-12"/>
        </div>

    </div>

    <div class='text-center lg:my-4'>
        <a href="{{ route('front.agenda.index') }}" class='btn btn-main' >
            See all
        </a>
    </div>
</div>


