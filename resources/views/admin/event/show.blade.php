<x-admin-layout>

    <div class='section flex justify-between'>
        <a href="{{ route('event.index')}}" class="btn">Back</a>
        <a href="{{ route('event.edit', $event->id)}}" class="btn">Edit</a>
    </div>

    @if($event->status == 'draft')
    <div class='section'>
        <div class='block-container p-4'>
            <form class="flex justify-between items-center gap-5">
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
            <div class='title-1'>
                Event Details
            </div>

            <x-event.event-detail :event="$event"/>
        </div>
    </div>

    {{-- display related media --}}
    @if($event->media()->count() > 0)
        <div class='section'>
            <div class='block-container p-4'>
                <div class='title-1'>
                    Media
                </div>
                <div class='flex gap-4 flex-wrap'>
                    @foreach($event->media as $media)
                        <x-media-thumbnail :media="$media"/>
                    @endforeach
                </div>

            </div>
        </div>
    @endif

    {{-- display related topic --}}
    @if($event->topic != null)
        <div class='section'>
            <div class='block-container p-4'>
                <div class='title-1'>
                    Topic Details
                </div>
                <x-topic.topic-detail :topic="$event->topic"/>
            </div>
        </div>
    @endif

    {{-- display related location --}}
    @if($event->location != null)
        <div class = 'section'>
            <div class= 'block-container p-4'>
                <div class='title-1'>
                    Location Details
                </div>
                <x-location.location-detail :location="$event->location"/>
            </div>
        </div>
    @endif


</x-admin-layout>
