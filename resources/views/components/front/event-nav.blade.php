{{--
    Event navigation — Prev/Next pink slabs with rotation hover.
    Usage: <x-front.event-nav :prevUrl="'/event/prev'" :nextUrl="'/event/next'" />
--}}
@props([
    'prevUrl' => null,
    'nextUrl' => null,
])

<nav class="evt-nav text-slate-900 flex static md:absolute top-[8rem] right-0 text-nav-sm md:text-nav-lg uppercase cursor-pointer">
    @if($prevUrl)
        <a href="{{ $prevUrl }}" class="evt-prev flex-1 md:block relative group pl-4 md:pl-0 bg-pink-200 md:bg-transparent">
            <div class="hidden md:block absolute top-0 left-0 h-full w-full bg-pink-200 group-hover:bg-yellow-100 group-hover:scale-x-[10%] transform group-hover:rotate-[-30deg] transition-all"></div>
            <div class="evt-label relative z-10 px-8 group-hover:scale-x-105 transition-all whitespace-nowrap">
                Prev
            </div>
        </a>
    @else
        <div class="evt-prev flex-1 md:block"></div>
    @endif

    @if($nextUrl)
        <a href="{{ $nextUrl }}" class="evt-next flex-1 md:block relative group pr-4 md:pr-0 text-right bg-pink-200 md:bg-transparent">
            <div class="hidden md:block absolute top-0 left-0 h-full w-full bg-pink-200 group-hover:bg-yellow-100 group-hover:scale-x-[10%] transform group-hover:rotate-[30deg] transition-all"></div>
            <div class="evt-label relative z-10 px-8 group-hover:scale-x-105 transition-all whitespace-nowrap">
                Next
            </div>
        </a>
    @else
        <div class="evt-next flex-1 md:block relative group pr-4 md:pr-0 text-right bg-pink-200 md:bg-transparent">
            <div class="hidden md:block absolute top-0 left-0 h-full w-full bg-pink-200 group-hover:bg-yellow-100 group-hover:scale-x-[10%] transform group-hover:rotate-[30deg] transition-all"></div>
            <div class="evt-label relative z-10 px-8 group-hover:scale-x-105 transition-all whitespace-nowrap">
                Next
            </div>
        </div>
    @endif
</nav>
