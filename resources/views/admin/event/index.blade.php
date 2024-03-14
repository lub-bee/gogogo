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
                    <!-- <th>Status</th> -->
                    <th>Topic</th>
                    <th>Location</th>
                    <th>Media</th>
                    <th>Start at</th>
                </tr>
                @foreach ($events as $event)
                    <tr>
                        <td>
                            <a href={{route('event.show', $event->id)}} class="hover:text-blue-500 cursor-pointer">
                                {{$event->name}}
                            </a>
                        </td>
                        <!-- <td class="uppercase text-center text-sm font-bold text-gray-500">
                            {{ $event->status }}
                        </td> -->
                        <td>
                            @if( $event->topic )
                            <a href={{route('topic.show', $event->topic->id)}} class="hover:text-blue-500 cursor-pointer">
                                {{$event->topic->name}}
                            </a>
                            @endif
                        </td>
                        <td>
                            @if ( $event->location )
                            <a href={{route('location.show', $event->location->id)}} class="hover:text-blue-500 cursor-pointer">
                                {{$event->location->name}}
                            </a>
                            @endif
                        </td>
                        <td>
                            {{-- <a href={{route('media.show', $event->media->id)}} class="hover:text-blue-500 cursor-pointer">
                                {{$event->media->name}}
                            </a> --}}
                        </td>
                        <td>
                            @if($event->start_at)
                                {{$event->start_at->format('y-m-d')}}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

</x-admin-layout>
