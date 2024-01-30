<x-admin-layout>

    {{-- @php dd($events) @endphp --}}

    @foreach ($events as $event)
        <a href={{route('event.show',$event->id)}} class="block hover:text-blue-500 transition">
            {{$event->name}} - {{$event->user_id}} - {{$event->updated_at}}
        </a>
    @endforeach

</x-admin-layout>
