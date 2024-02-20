<x-admin-layout>
    <div class="text-right mt-5 mx-4">
        <a href={{ route('event.edit', $event->id)}} class="border rounded border-blue-500 p-4 hover:text-white hover:bg-blue-500">Edit</a>
    </div>

    <div class="mt-4">
        <label>Name</label>
        {{$event->name}}
    </div>

    <div class="mt-4">
        <label>Start</label>
        {{$event->start_at}}
    </div>

    <div class="mt-4">
        <label>Cost</label>
        {{$event->cost}}
    </div>

    <div class="mt-4">
        <label>English</label>
        {{$event->description_en}}
    </div>
    <div class="mt-4">
        <label>Japanese</label>
        {{$event->description_ja}}
    </div>

    <div class="mt-4">
        <label></label>
        <a href={{route('user.show',$event->user->id)}}>{{ $event->user->name}}</a>
    </div>

</x-admin-layout>
