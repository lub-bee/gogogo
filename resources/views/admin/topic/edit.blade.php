<x-admin-layout>
    <form method="POST" action={{route("topic.update", $topic->id)}}>
        @csrf
        @method("PUT")

        <div class="section">
            <a href={{ route('topic.show', $topic->id)}} class="btn">Back</a>
        </div>
        <div class="section">
            <div class="container p-4">

                <div class="info">
                    <div>Name</div>
                    <div>
                        <input type="text" name="name" value="{{$topic->name}}"/>
                        @error("name")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Description (English)</div>
                    <div>
                        <input type="text" name="name" value="{{$topic->description_en}}"/>
                        @error("name")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Description (Japanese)</div>
                    <div>
                        <input type="text" name="name" value="{{$topic->description_ja}}"/>
                        @error("name")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

            <div>
                Last modification : {{$topic->updated_at}}
            </div>
            <div>
                Author : {{$topic->user->name}}
            </div>
            <div class="flex mt-5 gap-4 justify-center">
                <a href={{ route('topic.show', $topic->id)}} class="btn">
                    Cancel
                </a>
                <button type="submit" class="btn btn-main">
                    Edit
                </button>
            </div>


</x-admin-layout>
