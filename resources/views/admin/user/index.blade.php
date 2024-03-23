<x-admin-layout>

    <div class="section">
        <div class="text-right">
            <a href={{route("user.create")}} class="btn">Create</a>
        </div>
    </div>

    <div class='section'>
        <div class='block-container'>
            <table class="table my-5">
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Rank</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <a href={{route('user.show',$user->id)}} class="block hover:text-blue-500 transition">
                                {{$user->name}}
                            </a>
                        </td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->rank}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>


</x-admin-layout>
