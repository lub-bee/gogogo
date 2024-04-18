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

            <div class='info'>
                <div>Name</div>
                <div>
                    {{$topic->name}}
                </div>
            </div>

            <div class='info'>
                <div>Memo</div>
                <div>
                    {{$topic->memo}}
                </div>
            </div>

            <div class="info">
                <div>Content (EN)</div>
                <div class='formated-content col-span-3'>
                    {!! $topic->description_en !!}
                </div>
            </div>

            <div class="info">
                <div>Content (JA)</div>
                <div class='formated-content col-span-3'>
                    {!! $topic->description_ja !!}
                </div>
            </div>

            <div class="info">
                <div>Author</div>
                <div><a href="{{route('user.show',$topic->user->id)}}" class="hover:text-blue-500 cursor-pointer" class="link">{{ $topic->user->name}}</a></div>
            </div>

            <div class="info">
                <div>Status</div>
                <div>{{ $topic->publish_status }}</div>
                @if ($topic->isPublished())
                    <div>Published at</div>
                @endif
                @if($topic->isScheduled())
                    <div>Scheduled at</div>
                @endif

                @if( $topic->isPublished() || $topic->isScheduled())
                    <div>{{ $topic->published_at }}</div>
                @endif
            </div>

            <div class="info">
                <div>Created at</div>
                <div>{{ $topic->created_at }}</div>
                <div>Last Update</div>
                <div>{{ $topic->updated_at }}</div>
            </div>

        </div>
    </div>

</x-admin-layout>
