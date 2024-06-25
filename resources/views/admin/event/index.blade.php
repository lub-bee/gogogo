<x-admin-layout>

    <div class='section'>
        <div class="text-right">
            <a href="{{ route('event.create')}}" class="btn">Create</a>
        </div>
    </div>

    <div class='section'>
        <div class='block-container'>
            <table class="table my-5">
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Topic</th>
                    <th>Location</th>
                    <th>Media</th>
                    <th>Start at</th>
                </tr>
                @foreach ($events as $event)
                    <tr>

                        {{-- event name --}}
                        <td>
                            <a href="{{route('event.show', $event->id)}}" class="link">
                                {{$event->name}}
                            </a>
                        </td>

                        {{-- event status --}}
                        <td class="uppercase text-center text-sm font-bold text-gray-500">
                            {{$event->publish_status}}
                        </td>

                        {{-- event topic --}}
                        <td>
                            @if( $event->topic )
                            <a href="{{route('topic.show', $event->topic->id)}}" class="link" title="{{ $event->topic->name }}">
                                {{Str::limit($event->topic->name, 10)}}
                            </a>
                            @endif
                        </td>

                        {{-- event location --}}
                        <td>
                            @if ( $event->location )
                            <a href="{{route('location.show', $event->location->id)}}" class="link" title="{{ $event->location->name }}">
                                {{Str::limit($event->location->name,10)}}
                            </a>
                            @endif
                        </td>

                        {{-- event media --}}
                        <td>
                            <div class='flex gap-2'>
                                <a href="{{route('media.index', ['event' => $event->id ])}}" class='link'>
                                    {{ $event->medias()->count() }}
                                </a>
                                @if($event->medias()->isNotValidated()->count() > 0)
                                <a href="{{route('media.index', ['event' => $event->id ])}}" class="text-xs text-white bg-amber-500 font-bold hover:bg-amber-400 rounded p-px px-1 transition-all self-start">
                                    {{ $event->medias()->isNotValidated()->count() }} New
                                </a>
                                @endif
                            </div>
                        </td>

                        {{-- event start at --}}
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
