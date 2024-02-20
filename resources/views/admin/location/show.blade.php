location show
<x-admin-layout>

    <div>
        {{$location->name}}
    <div>

        <div>
            <button type="submit">
                SAVE
            </button>
        </div>
        <a href="{{$location->id}}/edit" class = "btn btn-default">EDIT</a>


</x-admin-layout>
