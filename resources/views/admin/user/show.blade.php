<x-admin-layout>

    <div class='section flex justify-between'>
        <a href={{ route('user.index')}} class="btn">Back</a>
        <a href={{ route('user.edit', $user->id)}} class="btn">Edit</a>
    </div>

    <div class='section'>
        <div class='block-container p-4'>

            <div class='info'>
                <div>Name</div>
                <div>
                    {{$user->name}}
                </div>
            </div>

            <div class='info'>
                <div>Email</div>
                <div>
                    {{$user->email}}
                </div>
            </div>

            <div class='info'>
                <div>Rank</div>
                <div>
                    {{$user->rank}}
                </div>
            </div>

            <div class="info">
                <div>Author</div>
                <div><a href={{route('user.show',$user->id)}}>{{ $user->name}}</a></div>
                <div>Last Updated</div>
                <div>{{ $user->updated_at }}</div>
            </div>
        </div>
    </div>

</x-admin-layout>
