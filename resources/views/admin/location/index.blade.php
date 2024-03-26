<x-admin-layout>

    <div class='section'>
        <div class="text-right">
            <a href='{{route("location.create")}}' class="btn">Create</a>
        </div>
    </div>

    <div class='section'>
        <div class='block-container'>
            <table class="table my-5 p-4">
                <tr>
                    <th>Name</th>
                    <th>Referee</th>
                    <th>Last Used</th>
                </tr>
                @foreach ($locations as $location)
                    <tr>
                        <td>
                            <a href="{{route('location.show',$location->id)}}" class="hover:text-blue-500 transition">
                                {{$location->name}}
                            </a>
                        </td>
                        <td>
                            <a href='{{route("user.show", $location->user->id)}}' class="hover:text-blue-500 cursor-pointer">
                                {{$location->user->name}}
                            </a>
                        </td>
                        <td>
                            {{--{{$location->last_used->format('y-m-d')}}--}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

</x-admin-layout>
