<nav class="text-slate-900 flex static md:absolute top-[8rem] right-0 text-[3.5rem] md:text-[7rem] leading-[2.3rem] md:leading-[4.5rem] uppercase  cursor-pointer" :class="mode === 'default' ? '' : 'hidden'">

    <div class='flex-1 md:block relative group pl-4 md:pl-0 bg-pink-200 md:bg-transparent'>
        <div class='hidden md:block absolute top-0 left-0 h-full w-full bg-pink-200 group-hover:bg-yellow-100 group-hover:scale-x-[10%] transform group-hover:rotate-[-30deg] transition-all'></div>
        <div class='relative z-10 px-8 group-hover:scale-x-105 transition-all'>
            Next
        </div>
    </div>

    <div class='flex-1 md:block relative group pr-4 md:pr-0 text-right bg-pink-200 md:bg-transparent'>
        <div class='hidden md:block absolute top-0 left-0 h-full w-full bg-pink-200 group-hover:bg-yellow-100 group-hover:scale-x-[10%] transform group-hover:rotate-[30deg] transition-all'></div>
        <div class='relative z-10 px-8 group-hover:scale-x-105 transition-all'>
            Prev
        </div>
    </div>

</nav>
