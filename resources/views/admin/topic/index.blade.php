<x-admin-layout>

    <div class='section'>
        <div class="text-right">
            <a href="{{ route('topic.create')}}" class="btn">Create</a>
        </div>
    </div>


    <div class='section'>
        <div class='block-container'>

            <table class="table my-5">
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Used Count</th>
                </tr>

                @foreach ($topics as $topic)
                    <tr>
                        <td>
                            <a href="{{route('topic.show', $topic->id)}}" class="link" title="See topic">
                                {{$topic->name}}
                            </a>
                        </td>
                        <td class="uppercase text-center text-sm font-bold text-gray-500">
                            {{ $topic->publish_status }}
                        </td>
                        <td>{{ $topic->Event()->count() }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-admin-layout>
