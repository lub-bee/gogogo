<x-admin-layout>
    User Index
    {{-- @php dd($users) @endphp --}}

    @foreach ($users as $user)
    <a href={{route('user.show',$user->id)}} class="block hover:text-blue-500 transition">
        {{$user->name}}- {{$user->email}} - {{$user->updated_at}}
        </a>
    @endforeach

</x-admin-layout>
