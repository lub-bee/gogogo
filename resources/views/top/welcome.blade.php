<x-public-layout>

        <section id="home" class="">
            Top
        </section>

        <section id="event" class="high-contrast flex flex-col relative" x-data="{mode: 'default'}">
            <header class="relative z-20">
                Event
            </header>

            <x-event.event-navigation/>

            <main class="flex-1 mt-4 md:mt-0 h-full flex flex-col md:flex-row items-center justify-evenly" :class="mode === 'default' ? '' : 'hidden'">
                <x-event.calendar-card year="2024" month="mar" day="22"/>
                <x-event.event-info-card/>
            </main>

            {{-- gallery --}}
            {{-- <div class="flex-1 relative flex flex-col bg-slate-900 media-gallery text-gray-400" :class="mode === 'media' ? '' : 'hidden'">
                <div class='absolute right-5 top-2 text-8xl z-20 hover:text-white cursor-pointer transition-all group' @click="mode = 'default'">
                    <i class='fa-solid fa-xmark group-hover:rotate-90 transition-all'></i>
                </div>

                <div class='flex-1 w-full p-4'>
                    <div class='w-full h-full overflow-x-auto flex gap-4 items-center snap-x'>
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

            </div> --}}
            <div class='absolute inset-0 bg-slate-900 flex flex-col gap-4 p-4 z-50' x-show='mode === "media"'>
                <div class='text-8xl uppercase text-slate-400 flex gap-8'>
                    <div class='flex-1 text-white'>
                        Media

                    </div>
                    <div class='pr-8 text-8xl z-20 hover:text-white cursor-pointer transition-all group' @click="mode = 'default'">
                        <i class='fa-solid fa-xmark group-hover:rotate-90 transition-all'></i>
                    </div>
                </div>
                <div class='flex-1 flex py-4 gap-4 overflow-scroll text-white'>
                    <div class='w-full h-full overflow-x-auto flex gap-4 items-center snap-x'>
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
            <div class='absolute inset-0 bg-slate-900 flex flex-col gap-16 p-4 z-50' x-show='mode === "topic"'>
                <div class='text-8xl text-slate-400 flex gap-8'>
                    <div class='flex-1'>
                        How to grill sardines only using the power of the Force.

                    </div>
                    <div class='pr-8 text-8xl z-20 hover:text-white cursor-pointer transition-all' @click="mode = 'default'">
                        <i class='fa-solid fa-xmark hover:rotate-90 transition-all'></i>
                    </div>
                </div>
                <div class='flex-1 flex py-4 gap-16 overflow-scroll text-slate-400'>
                    <div class='flex flex-col text-6xl uppercase'>
                        <div class='flex group justify-end'>
                            <div class='border-[3rem] border-transparent group-hover:border-t-slate-400 group-hover:border-r-slate-400  scale-x-0 group-hover:scale-x-[30%] origin-right transition-all'></div>
                            <div class='h-24 group-hover:bg-slate-400 flex items-center transition group-hover:text-slate-900'>
                                English
                            </div>
                        </div>
                        <div class='flex group justify-end'>
                            <div class='border-[3rem] border-transparent group-hover:border-t-slate-400 group-hover:border-r-slate-400  scale-x-0 group-hover:scale-x-[30%] origin-right transition-all'></div>
                            <div class='h-24 group-hover:bg-slate-400 flex items-center transition group-hover:text-slate-900'>
                                日本語
                            </div>
                        </div>
                        <div class='mt-24 flex flex-col group p-4 hover:bg-slate-400 transition-all'>
                            <div class='text-slate-900 transition text-center'>
                                Topic
                            </div>
                            <div class=' h-24 flex items-center transition group-hover:text-slate-900'>
                                Download
                            </div>
                        </div>

                    </div>
                    <div class='px-8 flex-1 overflow-y-scroll formated-content'>
                        <h1>TITLE 1</h1>
                        <h2>Subtitle</h2>
                        <h3>Subsubtitle</h3>
                        <p>Normal text</p>
                        <ol>
                            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span>1</li>
                            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span>2</li>
                            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span>3</li>
                            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span>4</li>
                            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span>5</li>
                        </ol>
                        <p>
                            <br>
                        </p>
                        <ol>
                            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>1</li>
                            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>2</li>
                            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>3</li>
                            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>4</li>
                            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>5</li>
                        </ol>
                        <p>
                            Some <a href="google.com" rel="noopener noreferrer" target="_blank">link</a> here, some <strong>bold text</strong>, some <u>underlined</u> and some <em>italic</em> there.
                        </p>
                    </div>
                    {{-- <div class='border-l-4 border-gray-300 pl-4 flex-1 overflow-y-scroll'>
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
                    </div> --}}
                </div>
                {{-- <div class='absolute -bottom-6'>
                    <button class="bg-blue-500 text-8xl text-white uppercase px-4 py-2">
                        <i class='fa-solid fa-download'></i> Download
                    </button>
                </div> --}}
            </div>

            {{-- location --}}
            <div class='absolute inset-0 bg-slate-900 flex flex-col gap-4 p-4 z-50' x-show='mode === "location"'>
                <div class='text-8xl text-slate-400 flex gap-8 items-center'>
                    <div class='text-5xl'>
                        At
                    </div>
                    <div class='flex-1'>
                        Café Haven't we met
                    </div>
                    <div class='self-stretch pr-8 text-8xl z-20 hover:text-white cursor-pointer transition-all group' @click="mode = 'default'">
                        <i class='fa-solid fa-xmark group-hover:rotate-90 transition-all'></i>
                    </div>
                </div>
                <div class='flex-1 flex py-4 gap-4 overflow-scroll text-white'>
                    <div class='flex-1 overflow-y-scroll'>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione et pariatur, ducimus impedit esse voluptate reiciendis ipsa. Saepe, unde. Quisquam eveniet ab non blanditiis, odit magni deserunt iusto ipsum voluptatum?<br/>
                    </div>
                </div>
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
