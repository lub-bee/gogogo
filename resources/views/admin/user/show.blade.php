<x-admin-layout>
    user show
    <div>
        {{$user->name}}
    <div>

        <a href="{{$user->id}}/edit" class = "btn btn-default">Edit</a>

</x-admin-layout>
