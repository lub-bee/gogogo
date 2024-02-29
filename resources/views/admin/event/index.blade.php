<x-admin-layout>

    <div class='section flex justify'>
        <div class="text-right">
            <a href={{ route('event.create')}} class="btn">Create</a>
        </div>
    </div>

    <div class='section'>
        <div class='block-container'>
            <table class="table mt-5">
                <tr>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Start at</th>
                    <th>Last Update</th>
                </tr>
                @foreach ($events as $event)
                    <tr>
                        <td><a href={{route('event.show', $event->id)}} class="hover:text-blue-500 cursor-pointer">{{$event->name}}</a></td>
                        <td>
                            <a href={{route('user.show', $event->user->id)}} class="hover:text-blue-500 cursor-pointer">
                                {{$event->user->name}}
                            </a>
                        </td>
                        <td>
                            @if($event->start_at)
                                {{$event->start_at->format('y-m-d')}}
                            @endif
                        </td>
                        <td>{{$event->updated_at->format("y-m-d H:i")}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

</x-admin-layout>
