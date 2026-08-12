{{--
    Top page — one-page with snap-scroll sections:
    Top → Event → Agenda → About → Topic → Media → Location
--}}

@php
    $startAt = $event ? $event->start_at : now();
@endphp

<x-layouts.public
    :menuItems="['top','event','agenda','about','topic','media','location']"
    title="GoGoGo">

    <main class="top relative h-screen snap-y snap-mandatory overflow-y-auto scroll-smooth">

        {{-- ===== SECTION: TOP ===== --}}
        <section id="top" class="top-section bg-white flex flex-col">
            <div class="flex-1 h-screen flex flex-col lg:flex-row overflow-hidden">
                {{-- Animated logo --}}
                <div class="flex-1 font-bold flex justify-center items-center text-slate-700">
                    <x-front.slot-logo />
                </div>

                {{-- Login form (guest state) / greeting (auth state) --}}
                <div class="flex-1 lg:flex-none lg:w-1/3 lg:max-w-[400px] lg:bg-gray-300">
                    @guest
                    <form method="POST" action="{{ route('login') }}" class="h-full flex flex-col gap-4 p-4 justify-center sm:max-w-sm lg:max-w-full mx-auto bg-slate-200 lg:bg-transparent">
                        @csrf
                        <div class="flex justify-between items-center border-b border-gray-400 mb-4 md:mt-8 uppercase text-slate-700">
                            Not a member yet? <a href="{{ route('register') }}" class="btn btn-success">Join us!</a>
                        </div>
                        <div>
                            <input type="email" name="email" placeholder="email" class="form-input" autocomplete="username" />
                        </div>
                        <div>
                            <input type="password" name="password" placeholder="password" class="form-input" required autocomplete="current-password" />
                        </div>
                        <div class="text-right">
                            <a href="{{ route('password.request') }}" class="text-slate-700 hover:underline">You have forgot your password?</a>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-main">sign in</button>
                        </div>
                    </form>
                    @else
                    <div class="h-full flex flex-col gap-2 p-4 justify-center sm:max-w-sm lg:max-w-full mx-auto bg-slate-200 lg:bg-transparent" x-data="{ mode: 'default' }">

                        {{-- Greeting — random EN/JA casual hello with user name --}}
                        <div class="text-2xl text-slate-700 mb-2">{{ $greeting }}</div>

                        {{-- Menu links --}}
                        <div class="flex flex-col gap-1" x-show="mode === 'default'">
                            @if(auth()->user()->hasRank('admin', 'support'))
                            <a href="{{ route('dashboard') }}" class="top-menu-link long group relative">
                                <span class="relative group-hover:text-orange-500 transition-all">Dashboard</span>
                            </a>
                            @endif
                            <div @click="mode = 'line'" class="top-menu-link line group relative cursor-pointer">
                                <span class="relative transition-all">Line</span>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="top-menu-link group relative">
                                <span class="relative group-hover:text-slate-500 transition-all">Profile</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="top-menu-link group relative text-left">
                                    <span class="relative group-hover:text-red-500 transition-all">Logout</span>
                                </button>
                            </form>
                        </div>

                        {{-- LINE panel --}}
                        <div x-show="mode === 'line'" class="flex flex-col gap-4">
                            <div @click="mode = 'default'" class="text-sm uppercase tracking-widest text-slate-500 cursor-pointer hover:text-slate-700 transition-all">
                                <i class="fa-solid fa-arrow-left fa-fw"></i> Back
                            </div>
                            <div class="bg-slate-700 text-white p-8 text-center uppercase font-bold text-lg tracking-wide">
                                line invitation
                            </div>
                            <div class="bg-slate-700 text-white p-8 text-center uppercase font-bold text-lg tracking-wide">
                                line invitation
                            </div>
                        </div>

                    </div>
                    @endguest
                </div>
            </div>
            <div class="flex-none h-4 bg-slate-700"></div>
        </section>

        {{-- ===== SECTION: EVENT ===== --}}
        <section id="event" class="top-section flex flex-col bg-white relative">
            <x-front.section-header bg="bg-slate-700" text="text-white">event</x-front.section-header>

            @if($event)
                <x-front.event-nav :prevUrl="$prevEventUrl" :nextUrl="$nextEventUrl" />

                <main class="flex-1 mt-4 md:mt-0 h-full flex flex-col md:flex-row items-center justify-evenly">
                    <div class="md:h-full md:w-auto flex flex-row md:flex-col justify-evenly items-center">
                        <x-front.calendar-card
                            :year="$startAt->format('Y')"
                            :day="$startAt->format('d')"
                            :month="$startAt->format('M')" />

                        {{-- Related links --}}
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
                            <a href="{{ route('media.index', ['event' => $event->slug]) }}" class="flex-1 flex items-center gap-4 group cursor-pointer">
                                <i class="fa-solid fa-images fa-fw"></i>
                                <div class="bg-sky-200 leading-5 hover:bg-orange-200 transition-all">Media</div>
                            </a>
                            @auth
                                @if($event->start_at && $event->start_at->timezone('Asia/Tokyo')->startOfDay()->lte(now('Asia/Tokyo')->startOfDay()))
                                <div x-data="{ uploadOpen: false }" class="flex-1 flex flex-col">
                                    <div @click="uploadOpen = !uploadOpen" class="flex items-center gap-4 group cursor-pointer">
                                        <i class="fa-solid fa-upload fa-fw"></i>
                                        <div class="bg-green-200 leading-5 hover:bg-orange-200 transition-all">Upload</div>
                                    </div>
                                    <div x-show="uploadOpen" x-transition class="absolute left-0 right-0 bottom-0 bg-white p-4 shadow-lg z-50 border-t-4 border-slate-700" style="display: none;" @click.outside="uploadOpen = false">
                                        <form method="POST" action="{{ route('media.upload') }}" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3 items-end max-w-3xl mx-auto">
                                            @csrf
                                            <input type="hidden" name="event_id" value="{{ $event->id }}" />
                                            <div class="flex-1">
                                                <label class="text-xs uppercase tracking-widest text-slate-500 font-bold mb-1 block">Images</label>
                                                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp,image/heic" class="form-input text-sm" required />
                                            </div>
                                            <div class="flex-1">
                                                <label class="text-xs uppercase tracking-widest text-slate-500 font-bold mb-1 block">Legend</label>
                                                <input type="text" name="legend" class="form-input text-sm" placeholder="Optional" maxlength="255" />
                                            </div>
                                            <button type="submit" class="btn btn-success text-lg whitespace-nowrap">Submit</button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            @endauth
                            @auth
                            @php $isAttendingTop = $event->attendees->contains(auth()->id()); @endphp
                            <form method="POST" action="{{ route('event.rsvp', $event) }}" class="flex-1 flex items-center">
                                @csrf
                                <button type="submit" class="flex items-center gap-4 group cursor-pointer">
                                    <i class="fa-solid fa-person-walking-luggage {{ $isAttendingTop ? 'fa-flip-horizontal' : '' }}"></i>
                                    <div class="{{ $isAttendingTop ? 'bg-yellow-200' : 'bg-sky-200' }} leading-5 hover:bg-yellow-200 transition-all">
                                        {{ $isAttendingTop ? "I'm not going" : "I'm going" }}
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

                    {{-- Event info --}}
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
            @else
                {{-- Empty state: no events --}}
                <div class="flex-1 flex items-center justify-center">
                    <div class="text-2xl text-slate-400 uppercase font-light">No upcoming events</div>
                </div>
            @endif
        </section>

        {{-- ===== SECTION: AGENDA ===== --}}
        <section id="agenda" class="top-section bg-slate-700 text-white flex flex-col">
            <x-front.section-header bg="bg-white" text="text-slate-700">Agenda</x-front.section-header>

            <x-front.diagonal-nav href="/agenda" color="blue" />

            <div class="flex-1 max-w-6xl mx-auto flex flex-col justify-evenly w-screen">
                @forelse($agendaMonths as $month)
                    <div class="flex flex-col lg:flex-row gap-4 lg:gap-14 mx-4 overflow-hidden">
                        <div class="lg:text-right flex-none lg:w-1/4 font-bold text-section-xs sm:text-section-sm lg:text-section tracking-poster">
                            {{ $month['name'] }}
                        </div>
                        <div class="flex-1 text-[2rem] sm:text-[2.5rem] leading-[3rem] sm:leading-[4.5rem] divide-y lg:divide-y-4">
                            @foreach($month['events'] as $evt)
                                <x-front.agenda-row
                                    :day="$evt['day']"
                                    :icon="$evt['icon']"
                                    :title="$evt['title']"
                                    :href="url('/event/' . ($evt['slug'] ?? '#'))" />
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="flex-1 flex items-center justify-center">
                        <div class="text-2xl text-slate-400 uppercase font-light">No events scheduled yet</div>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ===== SECTION: ABOUT ===== --}}
        <section id="about" class="top-section bg-slate-200 flex flex-col">
            <x-front.section-header bg="bg-slate-700" text="text-white">About US</x-front.section-header>

            <div class="flex-1 flex flex-col divide-y-4 divide-slate-700 w-screen lg:w-2/3 mx-auto justify-center px-4" x-data="{mode: '1'}">
                {{-- Q1: What is it? --}}
                <div>
                    <div class="text-3xl md:text-4xl py-2 font-bold uppercase flex flex-col items-start lg:items-center lg:flex-row gap-4" @click="mode = (mode == 1)?'false':'1'">
                        <div class="flex-1">
                            <i class="fa-solid fa-caret-right transition-all" :class="mode=='1' ? 'fa-rotate-90' : ''"></i>
                            五語Go, what is it?
                        </div>
                        <div class="text-slate-500 text-2xl self-end">五語Goって何ですか?</div>
                    </div>
                    <div class="accordion-panel" :class="mode == '1' ? 'is-open' : ''">
                        <div>
                            <div class="text-2xl uppercase py-4">
                                <div>It's a study group for people<br/>to learn English or Japanese</div>
                                <div class="mt-4 text-right text-slate-500">英語や日本語を学ぶための勉強会です。</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Q2: How does it work? --}}
                <div>
                    <div class="text-3xl md:text-4xl py-2 font-bold uppercase flex flex-col items-start lg:items-center lg:flex-row gap-4" @click="mode = (mode == 2)?'false':'2'">
                        <div class="flex-1 -tracking-[0.08em]">
                            <i class="fa-solid fa-caret-right transition-all" :class="mode=='2' ? 'fa-rotate-90' : ''"></i>
                            How does it works?
                        </div>
                        <div class="text-slate-500 text-2xl self-end">どうやって機能しますか？</div>
                    </div>
                    <div class="accordion-panel" :class="mode == '2' ? 'is-open' : ''">
                        <div>
                            <div class="md:text-2xl mx-auto grid grid-cols-3 md:grid-cols-2 items-center divide-x-4 divide-slate-700 py-4">
                                <div class="text-6xl md:text-[6rem] lg:text-[9rem] uppercase font-bold tracking-poster px-4 text-right">we</div>
                                <div class="col-span-2 md:col-span-1 flex flex-col uppercase px-4">
                                    <div>meet <b>every week</b></div>
                                    <div>talk <b>5 min</b> in <b>english</b></div>
                                    <div>talk <b>5 min</b> in <b>japanese</b></div>
                                    <div>repeat that for <b>30min</b></div>
                                </div>
                            </div>
                            <div class="md:text-2xl mx-auto grid grid-cols-3 md:grid-cols-2 items-center divide-x-4 divide-slate-700 py-4">
                                <div class="text-3xl md:text-[5rem] lg:text-[7rem] uppercase font-bold tracking-poster px-4 text-right">私たち</div>
                                <div class="col-span-2 md:col-span-1 flex flex-col uppercase px-4">
                                    <div>は<b>毎週</b>会います</div>
                                    <div>は<b>英語</b>で<b>5分</b>話します</div>
                                    <div>は<b>日本語</b>で<b>5分</b>話します</div>
                                    <div>は<b>30分</b>間繰り返します</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Q3: That's all? --}}
                <div>
                    <div class="text-3xl md:text-4xl py-2 font-bold uppercase flex flex-col items-start lg:items-center lg:flex-row gap-4" @click="mode = (mode == 3)?'false':'3'">
                        <div class="flex-1">
                            <i class="fa-solid fa-caret-right transition-all" :class="mode=='3' ? 'fa-rotate-90' : ''"></i>
                            That's all?
                        </div>
                        <div class="text-slate-500 text-2xl self-end">それだけですか？</div>
                    </div>
                    <div class="accordion-panel" :class="mode == '3' ? 'is-open' : ''">
                        <div>
                            <div class="grid grid-cols-2 gap-2 lg:flex lg:justify-between">
                                <div class="text-2xl uppercase">
                                    <b>No!</b><br/>We also do BBQs,<br/> festivals,<br/> sports activities,<br/> and much much more!
                                </div>
                                <div class="text-2xl text-right uppercase text-slate-500">
                                    <b>違います!</b><br/>バーベキュー<br/>やお祭り、<br/>スポーツ活動など、<br/>もっとたくさんのことを行っています！
                                </div>
                            </div>
                            <div class="text-center mt-8">
                                <a href="#media" class="btn btn-danger">Take a look!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===== SECTION: TOPIC ===== --}}
        <section id="topic" class="top-section bg-white flex flex-col">
            <x-front.section-header bg="bg-slate-200" text="text-slate-700">Topic</x-front.section-header>

            <x-front.diagonal-nav href="/topics" color="topic" />

            <x-front.topic-accordion :topics="$topics" />
        </section>

        {{-- ===== SECTION: MEDIA ===== --}}
        <section id="media" class="top-section bg-slate-700 flex flex-col">
            <x-front.section-header bg="bg-white" text="text-slate-700">Media</x-front.section-header>

            <x-front.diagonal-nav href="/media" color="blue" />

            <x-front.media-gallery :photos="$photos" />
        </section>

        {{-- ===== SECTION: LOCATION ===== --}}
        <section id="location" class="top-section bg-slate-200 flex flex-col">
            <x-front.section-header bg="bg-slate-700" text="text-white">Location</x-front.section-header>

            <x-front.diagonal-nav href="/locations" color="pink" />

            <div class="flex-1 max-w-6xl mx-auto flex flex-col justify-center w-full px-4">
                @forelse($locations as $loc)
                    <x-front.location-row
                        :icon="$loc['icon']"
                        :name="$loc['name']"
                        :count="$loc['count']"
                        :href="url('/location/' . ($loc['slug'] ?? '#'))" />
                @empty
                    <div class="flex items-center justify-center py-8">
                        <div class="text-2xl text-slate-400 uppercase font-light">No locations yet</div>
                    </div>
                @endforelse
            </div>
        </section>

    </main>
</x-layouts.public>
