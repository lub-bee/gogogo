@props(['media_id', 'topic_id', 'location_id'])
<div class='text-[1.3rem] sm:text-[2rem] flex flex-col h-full md:h-[25vh]'>

    <div class='flex-1 flex items-center gap-4 group cursor-pointer' @click="mode = 'media'">
        <i class='fa-solid fa-images fa-fw'></i>
        <div class='bg-sky-200 leading-5 hover:bg-orange-200 transition-all'>Media</div>
    </div>

    <div class='flex-1 flex items-center gap-4 group cursor-pointer' @click="mode = 'topic'">
        <i class='fa-solid fa-file-alt fa-fw'></i>
        <div class='bg-sky-200 leading-5 hover:bg-orange-200 transition-all'>Topic</div>
    </div>

    <div class='flex-1 flex items-center gap-4 group cursor-pointer' @click="mode = 'location'">
        <i class='fa-solid fa-location-dot fa-fw'></i>
        <div class='bg-sky-200 leading-5 hover:bg-orange-200 transition-all'>Location</div>
    </div>

    <div class='flex-1 flex items-center gap-4 group cursor-pointer'>
        <i class="fa-solid fa-person-walking-luggage"></i>
        <div class='bg-sky-200 leading-5 hover:bg-yellow-200 transition-all'>I'm going</div>
    </div>

</div>
