<x-public-layout>

        <section id="home" class="">
            Top
        </section>

        <section id="event" class="high-contrast flex flex-col relative" x-data="{mode: 'media'}">
            <header class="relative z-20">
                Event
            </header>

            <x-event.event-navigation/>

            <main class="flex-1 mt-4 md:mt-0 h-full flex flex-col md:flex-row items-center justify-evenly" :class="mode === 'default' ? '' : 'hidden'">
                <x-event.calendar-card year="2024" month="mar" day="22"/>
                <x-event.event-info-card/>
            </main>

            <div class="flex-1 relative flex flex-col bg-slate-900 media-gallery text-gray-400" :class="mode === 'media' ? '' : 'hidden'">
                <div class='absolute right-5 top-2 text-8xl z-20 hover:bg-white/20 cursor-pointer transition-all group' @click="mode = 'default'">
                    <i class='fa-solid fa-xmark group-hover:rotate-90 transition-all'></i>
                </div>

                <div class='flex-1 w-full p-4'>
                    <div class='bg-white/10 w-fill h-fill overflow-y-scroll overflow-x-hidden'>
                        <div class='flex flex-col'>
                            <img src="https://picsum.photos/200/300?randow=1"/>
                        </div>
                    </div>

                </div>
                {{-- <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="grid gap-4">
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image-1.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image-2.jpg" alt="">
                        </div>
                    </div>
                    <div class="grid gap-4">
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image-3.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image-4.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image-5.jpg" alt="">
                        </div>
                    </div>
                    <div class="grid gap-4">
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image-6.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image-7.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image-8.jpg" alt="">
                        </div>
                    </div>
                    <div class="grid gap-4">
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image-9.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image-10.jpg" alt="">
                        </div>
                        <div>
                            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/masonry/image-11.jpg" alt="">
                        </div>
                    </div>
                </div> --}}

            </div>

            <div class="flex-1 relative bg-slate-900 topic-display text-gray-400" :class="mode === 'topic' ? '' : 'hidden'">
                <div class='absolute right-2 top-2 text-8xl z-20 hover:bg-white/20 cursor-pointer transition-all group' @click="mode = 'default'">
                    <i class='fa-solid fa-xmark fa-fw group-hover:rotate-90 transition-all'></i>
                </div>
                Topic here
            </div>

            <div class="flex-1 relative bg-slate-900 location-display text-gray-400" :class="mode === 'location' ? '' : 'hidden'">
                <div class='absolute right-2 top-2 text-8xl z-20 hover:bg-white/20 cursor-pointer transition-all group' @click="mode = 'default'">
                    <i class='fa-solid fa-xmark fa-fw group-hover:rotate-90 transition-all'></i>
                </div>
                Location here
            </div>

        </section>

        <section id="about" class="low-contrast">
            <header class="">
                About
            </header>
            <main>
                List
            </main>
        </section>

        <section id="topic" class="high-contrast inverse">
            <header class="">
                Topic
            </header>
            <main>
                List
            </main>
        </section>

        <section id="media" class="high-contrast">
            <header class="">
                Media
            </header>
            <main>
                List
            </main>
        </section>

        <section id="location" class="low-contrast">
            <header class="">
                Location
            </header>
            <main>
                List
            </main>
        </section>

</x-public-layout>
