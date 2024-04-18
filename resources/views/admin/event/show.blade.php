<x-admin-layout>

    <div class='section flex justify-between'>
        <a href="{{ route('event.index')}}" class="btn">Back</a>
        <a href="{{ route('event.edit', $event->id)}}" class="btn">Edit</a>
    </div>

    @if($event->isDraft())
        <div class='section'>
            <div class='block-container p-4'>
                <form class="flex justify-between items-center gap-5" action="{{route('event.publish', $event->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <x-input-info level="warning" class="flex-1">
                        This event is currently still saved as a DRAFT.
                    </x-input-info>
                    <button type="submit" class="btn btn-main">Publish Now</button>
                </form>
            </div>
        </div>
    @endif

    <div class='section'>
        <div class='block-container p-4'>
            <x-event.event-detail :event="$event"/>
        </div>
    </div>

    {{-- display related topic --}}
    @if($event->topic != null)
        <div class='section'>
            <div class='block-container p-4'>
                <div class='title-1'>
                    Topic details
                </div>
                <x-topic.topic-detail :topic="$event->topic"/>
            </div>
        </div>
    @endif

</x-admin-layout>
