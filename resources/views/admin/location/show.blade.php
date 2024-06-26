<x-admin-layout>

    <div class='section'>
        <h1>Location details</h1>
    </div>

    {{-- nav --}}
    <div class='section flex justify-between'>
        <a href="{{ route('location.index')}}" class="btn">Back</a>
        <a href="{{ route('location.edit', $location->id)}}" class="btn">Edit</a>
    </div>

    {{-- location detail --}}
    <div class="section">
        <div class="block-container p-4">

            <x-location.location-detail :location="$location"/>

        </div>
    </div>

</x-admin-layout>
