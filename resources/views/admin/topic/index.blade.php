<x-admin-layout>

    <div class='section flex justify'>
        <div class="text-right">
            <a href={{ route('topic.create')}} class="btn">Create</a>
        </div>
    </div>


    <div class='section'>
        <div class='container'>
            <table class="table mt-5">
                <tr>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Description (English)</th>
                    <th>Description (Japanese)</th>
                </tr>

                @foreach ($topics as $topic)
                    <tr>
                        <td><a href={{route('topic.show', $topic->id)}} class="hover:text-blue-500 cursor-pointer">
                            {{$topic->name}}</a></td>
                        <td><a href={{route('topic.show', $topic->user->id)}} class="hover:text-blue-500 cursor-pointer">
                            {{$topic->user->name}}</a></td>
                        <td>{{$topic->description_en}}</td>
                        <td>{{$topic->description_ja}}</td>
                        <td>{{$topic->updated_at}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-admin-layout>
