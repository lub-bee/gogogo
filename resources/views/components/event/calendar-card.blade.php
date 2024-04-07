@props(['year' => 2022, 'month' => 12, 'day' => 30])
<div class=' flex-1w-full md:h-full md:w-auto flex flex-row md:flex-col justify-evenly items-center'>
    {{-- <x-event.calendar-card year="2024" month="mar" day="22"/> --}}
    <div class='w-40 md:w-60 text-slate-900'>

        <div class='font-bold text-[2rem] sm:text-[2.5rem] leading-[2rem] sm:leading-[3rem] text-center bg-slate-900 text-white'>
            {{ $year }}
        </div>

        <div class='text-[6rem] sm:text-[8rem] lg:text-[12rem] leading-[6rem] sm:leading-[7.5rem] lg:leading-[10rem] font-bold text-center'>
            {{ $day }}
        </div>

        <div class='uppercase font-bold text-[3rem] sm:text-[4.5rem] lg:text-[7rem] leading-[2rem] sm:leading-[3rem] lg:leading-[7rem] tracking-[0.01em] text-center'>
            {{ $month }}
        </div>

    </div>
    <x-event.responsive-related-card/>
</div>
