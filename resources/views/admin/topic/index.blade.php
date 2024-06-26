<x-admin-layout>

    <div class='section'>
        <h1>Topics</h1>
    </div>

    {{-- nav --}}
    <div class='section'>
        <div class="text-right">
            <a href="{{ route('topic.create')}}" class="btn">Create</a>
        </div>
    </div>

    {{-- topic list --}}
    <div class='section'>
        <div class='block-container'>

            <table class="table my-5">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Used Count</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($topics as $topic)
                        <tr>
                            {{-- topic name --}}
                            <td>
                                <a href="{{route('topic.show', $topic->id)}}" class="link" title="See topic">
                                    {{$topic->name}}
                                </a>
                            </td>

                            {{-- topic status --}}
                            <td class="uppercase text-center text-sm font-bold text-gray-500">
                                {{ $topic->publish_status }}
                            </td>

                            {{-- topic used count --}}
                            <td class="text-center">{{ $topic->Event()->count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
