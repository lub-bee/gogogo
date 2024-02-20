<x-admin-layout>

    <div class="text-right mt-5 mx-4">
        <a href={{ route('event.create')}} class="border rounded border-blue-500 p-4 hover:text-white hover:bg-blue-500">Create</a>
    </div>

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
    </div>

</x-admin-layout>
