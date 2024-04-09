@props(['event'])
<div class='title-1'>
    Event details
</div>

<div class='info'>
    <div>Name</div>
    <div>
        {{$event->name}}
    </div>
</div>

<div class="info">
    <div>Start</div>
    <div >
        {{$event->start_at}}
    </div>
    <div >End</div>
    <div >{{ $event->end_at }}</div>
</div>

<div class="info">
    <div>Cost</div>
    <div class=''>
        {{$event->cost}}
    </div>
</div>

<div class="info">
    <div class=''>Description (English)</div>
    <div class='col-span-3'>
        {{$event->description_en}}
    </div>
</div>

<div class="info">
    <div>Description (Japanese)</div>
    <div class="cols-span-3">
        {{$event->description_ja}}
    </div>
</div>

<div class="info">
    <div>Status</div>
    <div class=''>
        {{$event->publish_status}}
    </div>
</div>

<div class="info">
    <div>Topic</div>
    <div><a href="{{route('topic.show',$event->topic->id)}}" class="hover:text-blue-500 cursor-pointer">{{ $event->topic->name}}</a></div>
</div>
<div class="info">
    <div>Location</div>
    <div><a href="{{route('location.show',$event->location->id)}}" class="hover:text-blue-500 cursor-pointer">{{ $event->location->name}}</a></div>
</div>
<div class="info">
    <div>Author</div>
    <div><a href="{{route('user.show',$event->user->id)}}" class="hover:text-blue-500 cursor-pointer">{{ $event->user->name}}</a></div>
    <div>Last Update</div>
    <div>{{ $event->updated_at }}</div>
</div>
