@props(["title"=> "dummy title","description_en"=>"dummy description en","description_ja"=>"dummy description ja"])
<div class='w-full md:w-2/4'>
    <div class='xs:mt-4 px-4 lg:px-0 text-[2.5rem] xl:text-[5rem] leading-[2.5rem] xl:leading-[5rem] lg:tracking-tight font-bold uppercase'>
        {{ $title }}
    </div>
    <div class='px-4 lg:px-0 mt-4 lg:hover:scale-105 lg:text-lg transition-all max-h-[18vh] md:h-[30vh] overflow-y-scroll'>
        {!! $description_en !!}
    </div>
    <div class='px-4 lg:px-0 mt-4 lg:hover:scale-105 lg:text-lg transition-all max-h-[18vh] md:h-[30vh] overflow-y-scroll'>
        {!! $description_ja !!}
    </div>
</div>
