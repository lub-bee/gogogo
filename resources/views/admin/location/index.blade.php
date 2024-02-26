<x-admin-layout>

    <div class='section'>
        <div class="text-right">
            <a href={{route("location.create")}} class="btn">Create</a>
        </div>
    </div>

    <div class='section'>
        <div class='container'>
            <table class="table mt-5 p-4">
                <tr>
                    <th>Name</th>
                    <th>Referee</th>
                    <th>Website URL</th>
                    <th>Description (English)</th>
                    <th>Description (Japanese)</th>
                    <th>Cost</th>
                    <th>Updated at:</th>
                </tr>
                @foreach ($locations as $location)
                    <tr>
                        <td><a href={{route('location.show',$location->id)}} class="hover:text-blue-500 transition">{{$location->name}}</a></td>
                        <td>
                            <a href={{route("user.show", $location->user->id)}} class="hover:text-blue-500 cursor-pointer">
                                {{$location->user->name}}
                            </a>
                        </td>
                        <td>
                            {{--to check--}}
                            {{--@if($location->website_url)
                                {{$location->website_url->format('url')}}
                            @endif--}}
                        </td>
                        <td>{{$location->website_url}}</td>
                        <td>{{$location->description_en}}</td>
                        <td>{{$location->description_ja}}</td>
                        <td>{{$location->cost}}</td>
                        <td>{{$location->updated_at->format('y-m-d H:i')}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

</x-admin-layout>
