<x-admin-layout>

    <div class='section'>
        <h1>User details</h1>
    </div>

    <div class='section flex justify-between'>
        <a href="{{ route('user.index')}}" class="btn">Back</a>
        <a href="{{ route('user.edit', $user->id)}}" class="btn">Edit</a>
    </div>

    <div class='section'>
        <div class='block-container p-4'>

            {{-- name --}}
            <div class='info'>
                <div>Name</div>
                <div>
                    {{$user->name}}
                </div>
            </div>

            {{-- email --}}
            <div class='info'>
                <div>Email</div>
                <div>
                    {{$user->email}}
                </div>
            </div>

            {{-- rank --}}
            <div class='info'>
                <div>Rank</div>
                <div class="uppercase text-sm font-bold text-gray-500">
                    {{ App\Models\User::rankLabel($user->rank) }}
                </div>
            </div>

            {{-- created_at, updated_at --}}
            <div class="info">
                <div>Created</div>
                <div>{{ $user->created_at }}</div>
                <div>Last Updated</div>
                <div>{{ $user->updated_at }}</div>
            </div>
        </div>
    </div>

</x-admin-layout>
