@props(["event"])

<div class='w-40 md:w-60 text-slate-900'>

    <div class='font-bold text-[2rem] sm:text-[2.5rem] leading-[2rem] sm:leading-[3rem] text-center bg-slate-900 text-white'>
        {{ $event->start_at->format('Y') }}
    </div>

    <div class='text-[6rem] sm:text-[8rem] lg:text-[12rem] leading-[6rem] sm:leading-[7.5rem] lg:leading-[10rem] font-bold text-center'>
        {{ $event->start_at->format('d') }}
    </div>

    <div class='uppercase font-bold text-[3rem] sm:text-[4.5rem] lg:text-[7rem] leading-[2rem] sm:leading-[3rem] lg:leading-[7rem] tracking-[0.01em] text-center'>
        {{ $event->start_at->format('M') }}
    </div>

</div>
