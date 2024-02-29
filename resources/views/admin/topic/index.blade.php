<x-admin-layout>

    <div class='section'>
        <div class="text-right">
            <a href={{ route('topic.create')}} class="btn">Create</a>
        </div>
    </div>


    <div class='section'>
        <div class='block-container'>

            <table class="table mt-5">
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Author</th>
                    <th>Memo</th>
                    <th></th>
                </tr>

                @foreach ($topics as $topic)
                    <tr>
                        <td>
                            <a href={{route('topic.show', $topic->id)}} class="link" title="See topic">
                                {{$topic->name}}
                            </a>
                        </td>
                        <td class="uppercase text-center text-sm font-bold text-gray-500">
                            {{ $topic->status }}
                        </td>
                        <td>
                            <a href={{route('user.show', $topic->user->id)}} class="link" title="See author's contents">
                                {{$topic->user->name}}
                            </a>
                        </td>
                        <td>{{$topic->memo}}</td>
                        <td>{{$topic->updated_at->format('Y-m-d')}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-admin-layout>
