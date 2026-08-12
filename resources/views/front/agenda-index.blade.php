{{--
    Agenda index — all events with infinite scroll, walking backward in time.
    Fetches real data from /agenda?page=N JSON endpoint.
--}}

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

            {{-- Empty state --}}
            <div x-show="items.length === 0 && !loading && !nextPage" class="text-center py-16">
                <div class="text-2xl text-slate-400 uppercase font-light">No events yet</div>
            </div>

            {{-- Loading indicator --}}
            <div x-show="loading" class="text-center py-8">
                <div class="text-slate-400">Loading...</div>
            </div>

            {{-- Infinite scroll sentinel --}}
            <div x-ref="sentinel" class="h-4"></div>
        </main>

        <script>
            function agendaFeed() {
                return {
                    items: [],
                    nextPage: '/agenda?page=1',
                    loading: false,
                    lastYear: null,
                    init() {
                        this.loadMore();
                        this.$nextTick(() => {
                            const observer = new IntersectionObserver((entries) => {
                                if (entries[0].isIntersecting && !this.loading && this.nextPage) {
                                    this.loadMore();
                                }
                            }, { rootMargin: '200px' });
                            observer.observe(this.$refs.sentinel);
                        });
                    },
                    async loadMore() {
                        if (!this.nextPage || this.loading) return;
                        this.loading = true;
                        try {
                            const res = await fetch(this.nextPage, {
                                headers: { 'Accept': 'application/json' }
                            });
                            const data = await res.json();
                            for (const month of data.months) {
                                const year = month.year;
                                if (this.lastYear && year !== this.lastYear) {
                                    this.items.push({ type: 'year', year: year });
                                }
                                this.lastYear = year;
                                this.items.push(month);
                            }
                            this.nextPage = data.next_page;
                        } catch (e) {
                            console.error('Agenda load error:', e);
                        }
                        this.loading = false;
                    }
                };
            }
        </script>
    </div>
</x-layouts.public>
