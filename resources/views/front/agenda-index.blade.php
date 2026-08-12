{{--
    Agenda index — all events with infinite scroll, walking backward in time.
--}}
@props([])

<x-layouts.public
    :menuBack="['url' => url('/#agenda'), 'label' => 'Back']"
    title="Agenda — GoGoGo">

    <div class="min-h-screen bg-slate-700 text-white">
        {{-- Giant header --}}
        <div class="top">
            <x-front.section-header bg="bg-white" text="text-slate-700">Agenda</x-front.section-header>
        </div>

        {{-- Main content with Alpine infinite scroll --}}
        <main class="max-w-6xl mx-auto px-4 md:px-8 py-8" x-data="agendaFeed()">

            <template x-for="(item, ii) in items" :key="'i'+ii">
                <div>
                    {{-- Year marker --}}
                    <template x-if="item.type === 'year'">
                        <div class="text-center font-bold text-[5rem] sm:text-[8rem] lg:text-[12rem] leading-[4rem] sm:leading-[6rem] lg:leading-[10rem] -tracking-[0.14em] text-white mb-6 mt-2"
                             x-text="item.year"></div>
                    </template>
                    {{-- Month row --}}
                    <template x-if="item.type === 'month'">
                        <div class="flex flex-col lg:flex-row gap-4 lg:gap-14 mb-10">
                            <div class="lg:text-right flex-none lg:w-1/4 font-bold text-section-xs sm:text-section-sm lg:text-section tracking-poster"
                                 x-text="item.name"></div>
                            <div class="flex-1 text-[2rem] sm:text-[2.5rem] leading-[3rem] sm:leading-[4.5rem] divide-y lg:divide-y-4">
                                <template x-for="(ev, ei) in item.events" :key="'e'+ii+'-'+ei">
                                    <a class="flex gap-8 group" :href="'/event/' + ev.slug">
                                        <div class="font-bold tracking-widest" x-text="ev.day"></div>
                                        <div><i class="fas fa-fw" :class="ev.icon"></i></div>
                                        <div class="-tracking-[0.08em] font-light group-hover:tracking-tight transition-all whitespace-nowrap"
                                             x-text="ev.title"></div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            {{-- Infinite scroll sentinel --}}
            <div x-ref="sentinel" class="h-4"></div>
        </main>

        <script>
            function agendaFeed() {
                const monthNames = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEPT','OCT','NOV','DEC'];
                const eventPool = [
                    { title: 'Gogogo at The Mall', icon: 'fa-book', slug: 'gogogo-mall' },
                    { title: 'Badminton night!', icon: 'fa-mug-hot', slug: 'badminton' },
                    { title: 'Oktoberfest at Nichikichou Koen', icon: 'fa-mug-hot', slug: 'oktoberfest' },
                    { title: 'Trip to Matsushima', icon: 'fa-mug-hot', slug: 'matsushima' },
                    { title: 'Gogogo Friday', icon: 'fa-book', slug: 'gogogo-friday' },
                    { title: 'Hanami picnic', icon: 'fa-mug-hot', slug: 'hanami' },
                    { title: 'Gogogo Sunday', icon: 'fa-book', slug: 'gogogo-sunday' },
                    { title: 'Board game night', icon: 'fa-mug-hot', slug: 'board-game' }
                ];
                return {
                    items: [],
                    curMonth: new Date().getMonth(),
                    curYear: new Date().getFullYear(),
                    startYear: new Date().getFullYear(),
                    loading: false,
                    init() {
                        this.addBatch();
                        this.$nextTick(() => {
                            const observer = new IntersectionObserver((entries) => {
                                if (entries[0].isIntersecting && !this.loading) {
                                    this.loading = true;
                                    setTimeout(() => { this.addBatch(); this.loading = false; }, 300);
                                }
                            }, { rootMargin: '200px' });
                            observer.observe(this.$refs.sentinel);
                        });
                    },
                    addBatch() {
                        for (let b = 0; b < 3; b++) {
                            const name = monthNames[this.curMonth];
                            const seed = this.curMonth + this.curYear * 12;
                            const count = 2 + (seed % 3);
                            const events = [];
                            for (let e = 0; e < count; e++) {
                                const pool = eventPool[(seed * 3 + e) % eventPool.length];
                                const day = String(5 + e * 7 + (seed % 5)).padStart(2, '0');
                                events.push({ day, title: pool.title, icon: pool.icon, slug: pool.slug });
                            }
                            this.items.push({ type: 'month', name, events });
                            this.curMonth--;
                            if (this.curMonth < 0) {
                                this.curMonth = 11;
                                this.curYear--;
                                if (this.curYear !== this.startYear) {
                                    this.items.push({ type: 'year', year: String(this.curYear) });
                                }
                            }
                        }
                    }
                };
            }
        </script>
    </div>
</x-layouts.public>
