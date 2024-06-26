<x-admin-layout>

    <div class='section'>
        <h1>Locations</h1>
    </div>

    {{-- nav --}}
    <div class='section'>
        <div class="text-right">
            <a href='{{route("location.create")}}' class="btn">Create</a>
        </div>
    </div>

    {{-- location list --}}
    <div class='section'>
        <div class='block-container'>

            <table class="table my-5 p-4">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="text-center">GPS</th>
                        <th class="text-center">Desc.</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($locations as $location)
                        <tr>
                            {{-- name --}}
                            <td>
                                <a href="{{route('location.show',$location->id)}}" class="link">
                                    {{$location->name}}
                                </a>
                            </td>

                            {{-- gps status--}}
                            <td class="text-center">
                                @if($location->gps_lat && $location->gps_long)
                                    <i class='fa-regular fa-circle-check text-green-500'></i>
                                @else
                                    <i class='fa-regular fa-circle-xmark text-red-500'></i>
                                @endif
                            </td>

                            {{-- description status --}}
                            <td class="text-center">
                                @if($location->description_en)
                                    <i class='fa-regular fa-circle-check text-green-500'></i>
                                @else
                                    <i class='fa-regular fa-circle-xmark text-red-500'></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
