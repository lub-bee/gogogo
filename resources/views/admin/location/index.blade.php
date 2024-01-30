<x-admin-layout>
    location index

    {{-- @php dd($locations) @endphp --}}

    @foreach ($locations as $location)
        <a href={{route('location.show',$location->id)}} class="block hover:text-blue-500 transition">
            {{$location->name}}- {{$location->user_id}} - {{$location->updated_at}}
        </a>
    @endforeach

</x-admin-layout>
