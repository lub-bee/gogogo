<x-public-layout>

    <x-front.section id="top" class="bg-white flex flex-col">
        <div class='flex-1 flex flex-col lg:flex-row'>
            <div class='flex-1 text-[5rem] sm:text-[9rem] font-bold flex justify-center items-center text-slate-700'>
                五語Go!
            </div>
            <div class='lg:w-1/3 flex-none bg-gray-300'>
                <form method="POST" action="{{ route('login') }}" class="h-full flex flex-col gap-4 p-4 xl:p-14 justify-center sm:max-w-sm lg:max-w-full mx-auto">
                    <div class='flex justify-between items-center border-b border-gray-400 mb-4 md:mt-8 uppercase'>
                        Not a member yet? <a href="{{ route('register') }}" class='btn btn-success'>Join us!</a>
                    </div>
                    <div class=''>
                        <input type="text" placeholder="email" class="form-input"/>
                    </div>
                    <div class=''>
                        <input type="password" placeholder="password" class="form-input"/>
                    </div>
                    <div class='text-right'>
                        <a href="{{ route('password.request') }}" class="text-slate-700 hover:underline">You have forgot your password?</a>
                    </div>
                    <div class='text-center'>
                        <button type="submit" class="btn btn-main">{{ __('sign in') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class='flex-none h-4 bg-slate-700'></div>
    </x-front.section>

    <x-front.section id="event" class="flex flex-col bg-white relative">
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

        <div class='flex-1 max-w-6xl mx-auto flex flex-col justify-evenly'>
            <div class='flex flex-col lg:flex-row gap-4 lg:gap-14'>
                <div class='lg:text-right flex-none lg:w-1/4 font-bold text-[3rem] sm:text-[4.5rem] lg:text-[7rem] leading-[2rem] md:leading-[3rem] lg:leading-[6rem] -tracking-[0.12em]'>
                    SEPT
                </div>
                <div class='flex-1 text-[2rem] sm:text-[2.5rem] leading-[3rem] sm:leading-[4.5rem] divide-y lg:divide-y-4'>
                    <x-front.event.event-agenda-tile date="22" title="Gogogo at The Mall" slug="2024-9-22"/>
                    <x-front.event.event-agenda-tile date="25" title="Badminton night!" slug="2024-9-25"/>
                    <x-front.event.event-agenda-tile date="29" title="Oktoberfes at Nichikichou Koen" slug="2024-9-29"/>
                </div>
            </div>

            <div class='flex flex-col lg:flex-row gap-4 lg:gap-14'>
                <div class='lg:text-right flex-none lg:w-1/4 font-bold text-[3rem] sm:text-[4.5rem] lg:text-[7rem] leading-[2rem] sm:leading-[3rem] lg:leading-[6rem] -tracking-[0.12em]'>
                    OCT
                </div>
                <div class='flex-1 font-bold text-[2rem] sm:text-[2.5rem] leading-[3rem] sm:leading-[4.5rem] divide-y lg:divide-y-4'>
                    <x-front.event.event-agenda-tile date="07" title="Trip to Matsushima" slug="2024-10-07"/>
                    <x-front.event.event-agenda-tile date="12" title="Gogogo Friday" slug="2024-10-12"/>
                </div>

            </div>

            <div class='text-center lg:my-4'>
                <a href="{{ route('front.agenda.index') }}" class='btn btn-main' >
                    See all
                </a>
            </div>
        </div>



    </x-front.section>

    <x-front.section id="about" class="bg-slate-200 flex flex-col">
        <header class='bg-slate-700 text-white'>
            About US
        </header>

        <div class='flex-1 flex flex-col divide-y-4 divide-slate-700 w-2/3 mx-auto justify-center' x-data="{mode: 'default'}">

            <div class='' x-data="{open: false}">
                <div class='text-4xl py-2 font-bold uppercase' @click="open = !open">
                    <i class='fa-solid fa-caret-right transition-all mr-4' :class="open ? 'fa-rotate-90' : ''"></i>
                    五語Go, what is it?
                </div>

                <div class='text-2xl uppercase text-right py-4' x-show="open">
                    It's a study group for people<br/>to learn English or Japanese
                </div>
            </div>

            <div class='' x-data="{open: false}">
                <div class='text-4xl py-2 font-bold uppercase' @click="open = !open">
                    <i class='fa-solid fa-caret-right transition-all mr-4' :class="open ? 'fa-rotate-90' : ''"></i>
                    How it works?
                </div>

                <div class='text-2xl mx-auto flex justify-center items-center divide-x-4 divide-slate-700 py-4' x-show="open">
                    <div class='text-[9rem] uppercase font-bold -tracking-[0.12em] px-4'>we</div>
                    <div class='flex flex-col uppercase px-4'>
                        <div class=''>meet <b>every week</b></div>
                        <div class=''>talk <b>5 min</b> in <b>english</b></div>
                        <div class=''>talk <b>5 min</b> in <b>japanese</b></div>
                        <div class=''>repeat that for <b>30min</b></div>
                    </div>
                </div>
            </div>

            <div class='' x-data="{open: false}">
                <div class='text-4xl py-2 font-bold uppercase' @click="open = !open">
                    <i class='fa-solid fa-caret-right transition-all mr-4' :class="open ? 'fa-rotate-90' : ''"></i>
                    That's all?
                </div>
                <div class='text-2xl text-right uppercase' x-show="open">
                    No!<br/>
                    We also do BBQs,<br/> festivals,<br/> sports activities,<br/> and much much more!
                </div>
            </div>

        </div>
    </x-front.section>

    <x-front.section id="media" class="bg-slate-700">
        <header class='bg-gray-200 text-slate-700'>
            Media
        </header>
    </x-front.section>

    <x-front.section id="topic" class="bg-blue-200">
        <header class='bg-slate-700 text-blue-200'>
            topic
        </header>
    </x-front.section>

</x-public-layout>
