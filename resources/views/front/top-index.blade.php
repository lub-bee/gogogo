<x-public-layout>

    <x-front.section id="top" class="bg-white flex flex-col">
        <div class='flex-1 flex flex-col lg:flex-row'>
            <div class='flex-1 text-[5rem] sm:text-[9rem] font-bold flex justify-center items-center text-slate-700'>
                五語Go!
            </div>
            <div class='lg:w-1/3 flex-none bg-gray-300'>
                <form method="POST" action="{{ route('login') }}" class="h-full flex flex-col gap-4 p-4 xl:p-14 justify-center sm:max-w-sm lg:max-w-full mx-auto">
                    @csrf
                    <div class='flex justify-between items-center border-b border-gray-400 mb-4 md:mt-8 uppercase'>
                        Not a member yet? <a href="{{ route('register') }}" class='btn btn-success'>Join us!</a>
                    </div>
                    <div class=''>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <input type="email" name="email" placeholder="email" class="form-input" autocomplete="username"/>
                    </div>
                    <div class=''>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <input type="password" name="password" placeholder="password" class="form-input" required autocomplete="current-password"/>
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



    </x-front.section>

    <x-front.section id="about" class="bg-slate-200 flex flex-col">
        <header class='bg-slate-700 text-white'>
            About US
        </header>

        <div class='flex-1 flex flex-col divide-y-4 divide-slate-700 w-2/3 mx-auto justify-center' x-data="{mode: '1'}">

            <div class='' x-data="{open: false}">
                <div class='text-4xl py-2 font-bold uppercase flex gap-4 items-center' @click="mode = (mode == 1)?'false':'1'">
                    <i class='fa-solid fa-caret-right transition-all' :class="mode=='1' ? 'fa-rotate-90' : ''"></i>
                    <div class='flex-1'>
                        五語Go, what is it?
                    </div>
                    <div class='text-slate-500 text-2xl'>
                        五語Goって何ですか?
                    </div>
                </div>

                <div class='text-2xl uppercase py-4' x-show="mode == '1'">
                    <div class=''>
                        It's a study group for people<br/>to learn English or Japanese
                    </div>

                    <div class='mt-4 text-right text-slate-500'>
                        英語や日本語を学ぶための勉強会です。
                    </div>
                </div>
            </div>

            <div class=''>
                <div class='text-4xl py-2 font-bold uppercase flex items-center gap-4' @click="mode = (mode == 2)?'false':'2'">
                    <i class='fa-solid fa-caret-right transition-all' :class="mode=='2' ? 'fa-rotate-90' : ''"></i>
                    <div class='flex-1 -tracking-[0.08em]'>
                        How does it works?
                    </div>
                    <div class='text-slate-500 text-2xl'>
                        どうやって機能しますか？
                    </div>
                </div>

                <div class='text-2xl mx-auto grid grid-cols-2 items-center divide-x-4 divide-slate-700 py-4' x-show="mode == '2'">
                    <div class='text-[9rem] uppercase font-bold -tracking-[0.12em] px-4 text-right'>we</div>
                    <div class='flex flex-col uppercase px-4'>
                        <div class=''>meet <b>every week</b></div>
                        <div class=''>talk <b>5 min</b> in <b>english</b></div>
                        <div class=''>talk <b>5 min</b> in <b>japanese</b></div>
                        <div class=''>repeat that for <b>30min</b></div>
                    </div>
                </div>
                <div class='text-2xl mx-auto grid grid-cols-2 items-center divide-x-4 divide-slate-700 py-4' x-show="mode == '2'">
                    <div class='text-[7rem] uppercase font-bold -tracking-[0.12em] px-4 text-right'>私たち</div>
                    <div class='flex flex-col uppercase px-4'>
                        <div class=''>は<b>毎週</b>会います</div>
                        <div class=''>は<b>英語</b>で<b>5分</b>話します</div>
                        <div class=''>は<b>日本語</b>で<b>5分</b>話します</b></div>
                        <div class=''>は<b>30分</b>間繰り返します</div>

                    </div>
                </div>
            </div>

            <div class=''>
                <div class='text-4xl py-2 font-bold uppercase flex gap-4' @click="mode = (mode == 3)?'false':'3'">
                    <i class='fa-solid fa-caret-right transition-all' :class="mode=='3' ? 'fa-rotate-90' : ''"></i>
                    <div class='flex-1'>
                        That's all?
                    </div>
                    <div class='text-slate-500 text-2xl'>
                        それだけですか？
                    </div>
                </div>
                <div class='' x-show="mode == '3'">

                    <div class='flex justify-between'>
                        <div class='text-2xl uppercase'>
                            <b>No!</b><br/>
                            We also do BBQs,<br/> festivals,<br/> sports activities,<br/> and much much more!
                        </div>
                        <div class='text-2xl text-right uppercase text-slate-500' x-show="mode == '3'">
                            <b>違います!</b><br/>
                            バーベキュー<br/>
                            やお祭り、<br/>スポーツ活動など、<br/>もっとたくさんのことを行っています！
                        </div>
                    </div>
                    <div class='text-center mt-8'>
                        <a href="#media" class="btn btn-danger">Take a look!</a>
                    </div>
                </div>
            </div>

        </div>
    </x-front.section>

    <x-front.section id="media" class="bg-slate-600">
        <header class='bg-slate-200 text-slate-600'>
            Media
        </header>
    </x-front.section>

    <x-front.section id="topic" class="bg-blue-200">
        <header class='bg-slate-600 text-blue-200'>
            topic
        </header>
    </x-front.section>

</x-public-layout>
