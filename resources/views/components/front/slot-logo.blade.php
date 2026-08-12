{{--
    Slot-machine logo — 3 columns cycling 五語Go characters.
    The animation is driven by resources/js/app.js (DOMContentLoaded handler).
--}}
<a href="#about" class="flex cursor-pointer">
    <div id="slot1" class="slot h-[10rem] text-[5rem] md:text-[9rem] leading-[9rem] w-28 md:w-48 flex items-center justify-center overflow-hidden relative">
        <div class="letters absolute inset-0 transition-transform duration-500 text-center">
            <div>五</div>
            <div>5</div>
            <div>ご</div>
            <div>ゴ</div>
            <div>Go</div>
        </div>
    </div>
    <div id="slot2" class="slot h-[10rem] text-[5rem] md:text-[9rem] leading-[9rem] w-28 md:w-48 flex items-center justify-center overflow-hidden relative">
        <div class="letters absolute inset-0 transition-transform duration-500 text-center">
            <div>語</div>
            <div>ご</div>
            <div>ゴ</div>
            <div>Go</div>
        </div>
    </div>
    <div id="slot3" class="slot h-[10rem] text-[5rem] md:text-[9rem] leading-[9rem] w-28 md:w-52 flex items-center justify-center overflow-hidden relative">
        <div class="letters absolute inset-0 transition-transform duration-500 text-center">
            <div>Go</div>
            <div>ゴ</div>
            <div>ご</div>
        </div>
    </div>
</a>
