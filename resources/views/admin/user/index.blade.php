<x-admin-layout>

    <div class='section'>
        <h1>Users</h1>
    </div>

    <div class="section">
        <div class="text-right">
            <a href='{{route("user.create")}}' class="btn">Create</a>
        </div>
    </div>

    <div class='section'>
        <div class='block-container'>
            <table class="table my-5">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center">Rank</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <a href="{{route('user.show',$user->id)}}" class="link">
                                {{$user->name}}
                            </a>
                        </td>
                        <td>{{$user->email}}</td>
                        <td class="uppercase text-center text-sm font-bold text-gray-500">{{ App\Models\User::rankLabel($user->rank) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>


</x-admin-layout>
