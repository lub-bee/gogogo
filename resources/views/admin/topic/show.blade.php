<x-admin-layout>

    <div class='section flex justify-between'>
        <a href="{{ route('topic.index')}}" class="btn">Back</a>
        <a href="{{ route('topic.edit', $topic->id)}}" class="btn">Edit</a>
    </div>

    @if($topic->isDraft())
    <div class='section'>
        <div class='block-container p-4'>
            <form class="flex justify-between items-center gap-5" action="{{route('topic.publish', $topic->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <x-input-info level="warning" class="flex-1">
                    This topic is currently still saved as a DRAFT.
                </x-input-info>
                <button type="submit" class="btn btn-main">Publish Now</button>
            </form>
        </div>
    </div>
    @endif

    <div class='section'>
        <div class='block-container p-4'>

            <x-topic.topic-detail :topic="$topic"/>

        </div>
    </div>

</x-admin-layout>
