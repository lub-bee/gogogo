<x-public-layout>

        <section id="home" class="">
            Top
        </section>

        <section id="event" class="high-contrast flex flex-col relative" x-data="{mode: 'topic'}">
            <header class="relative z-20">
                Event
            </header>

            <x-event.event-navigation/>

            <main class="flex-1 mt-4 md:mt-0 h-full flex flex-col md:flex-row items-center justify-evenly" :class="mode === 'default' ? '' : 'hidden'">
                <x-event.calendar-card year="2024" month="mar" day="22"/>
                <x-event.event-info-card/>
            </main>

            {{-- gallery --}}
            <div class="flex-1 relative flex flex-col bg-slate-900 media-gallery text-gray-400" :class="mode === 'media' ? '' : 'hidden'">
                <div class='absolute right-5 top-2 text-8xl z-20 hover:text-white cursor-pointer transition-all group' @click="mode = 'default'">
                    <i class='fa-solid fa-xmark group-hover:rotate-90 transition-all'></i>
                </div>

                <div class='flex-1 w-full p-4'>
                    <div class='bg-white/10 w-full h-full overflow-x-auto flex gap-4 items-center snap-x'>
                            <img src="https://picsum.photos/400/300?randow=1" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/200/300?randow=2" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/240/360?randow=3" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/600/300?randow=4" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/360/240?randow=5" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/840/600?randow=6" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/300/300?randow=7" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/300/630?randow=8" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/240/480?randow=9" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/200/300?randow=10" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/200/300?randow=11" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/200/300?randow=12" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/840/600?randow=13" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/600/300?randow=14" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/360/240?randow=15" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/240/360?randow=16" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/200/300?randow=17" class="media-tile shrink-0 snap-center"/>
                            <img src="https://picsum.photos/400/300?randow=18" class="media-tile shrink-0 snap-center"/>
                    </div>

                </div>

            </div>

            {{-- topic --}}
            <div class="fixed z-40 top-0 left-0 h-full w-full bg-slate-900 topic-display text-gray-400" :class="mode === 'topic' ? '' : 'hidden'">
                <div class='absolute right-2 top-2 text-8xl z-20 hover:bg-white/20 cursor-pointer transition-all group' @click="mode = 'default'">
                    <i class='fa-solid fa-xmark fa-fw group-hover:rotate-90 transition-all'></i>
                </div>

                <div class='h-full'>
                    <div class='mx-8 text-[5rem] mr-32 leading-[5.5rem]'>
                        Super topic title with a lot of text to see how it looks like
                    </div>

                    <div class='flex gap-8 max-h-full overflow-y-auto'>
                        <div class='formated-content p-8'>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/><br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/><br/><br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/><br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/><br/><br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/><br/><br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/><br/><br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/><br/><br/>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                        </div>
                        <div class='.formated-content'>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aliquam, expedita. Rerum ratione enim iure illo voluptatum! Repudiandae, beatae itaque suscipit optio aliquam ad, omnis, consequuntur nobis dolorem mollitia ullam et.
                        </div>
                    </div>

                </div>
            </div>

            {{-- location --}}
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
