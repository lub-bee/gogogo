{{-- @php
    dd($topics);
    @endphp --}}
    {{--
    index
    You're looking at the topic all the topics <br/>

    @foreach ($topics as $topic)
        {{$topic->name}} - {{$topic->user_id}} - {{$topic->updated_at}}<br/>
    @endforeach --}}

{{--QUESTION - Does difference impact on speed?--}}
<x-admin-layout>

    {{-- @php dd($topics) @endphp --}}

    @foreach ($topics as $topic)
        <a href={{route('topic.show',$topic->id)}} class="block hover:text-blue-500 transition">
        {{$topic->name}}- {{$topic->user_id}} - {{$topic->updated_at}}
            </a>
    @endforeach

</x-admin-layout>
