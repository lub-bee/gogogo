<x-admin-layout>

    <div class='section flex justify-between'>
        <a href={{ route('topic.index')}} class="btn">Back</a>
        <a href={{ route('topic.edit', $topic->id)}} class="btn">Edit</a>
    </div>

    <div class='section'>
        <div class='container p-4'>

            <div class='info'>
                <div>Name</div>
                <div>
                    {{$topic->name}}
                </div>
            </div>

            <div class="info">
                <div>Description (English)</div>
                <div class=''>
                    {{$topic->description_en}}
                </div>
            </div>

            <div class="info">
                <div>Description (Japanese)</div>
                <div class=''>
                    {{$topic->description_ja}}
                </div>
            </div>

            <div class="info">
                <div>Author</div>
                <div><a href={{route('topic.show',$topic->user->id)}}>{{ $topic->user->name}}</a></div>
                <div>Last Update</div>
                <div>{{ $topic->updated_at }}</div>
            </div>

        </div>
    </div>

</x-admin-layout>
