{{--
    Calendar card — year / day / month display.
    Usage: <x-front.calendar-card :year="2024" :day="22" month="Sep" />
--}}
@props([
    'year' => date('Y'),
    'day'  => date('d'),
    'month' => date('M'),
])

<div class="w-40 md:w-60 text-slate-900">
    <div class="font-bold text-[2rem] sm:text-[2.5rem] leading-[2rem] sm:leading-[3rem] text-center bg-slate-900 text-white">
        {{ $year }}
    </div>
    <div class="text-[6rem] sm:text-[8rem] lg:text-[12rem] leading-[6rem] sm:leading-[7.5rem] lg:leading-[10rem] font-bold text-center">
        {{ str_pad($day, 2, '0', STR_PAD_LEFT) }}
    </div>
    <div class="uppercase font-bold text-[3rem] sm:text-[4.5rem] lg:text-[7rem] leading-[2rem] sm:leading-[3rem] lg:leading-[7rem] tracking-[0.01em] text-center">
        {{ $month }}
    </div>
</div>
