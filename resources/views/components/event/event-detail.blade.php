@props(['event'])

{{-- event name --}}
<div class='info'>
    <div>Name</div>
    <div class="col-span-3">{{$event->name}}</div>
</div>

{{-- event time --}}
<div class="info">
    <div>Start</div>
    <div>{{$event->start_at}}</div>

    @if ($event->end_at)
        <div>End</div>
        <div>{{ $event->end_at }}</div>
    @endif
</div>

{{-- event cost --}}
@if($event->cost)
    <div class="info">
        <div>Cost</div>
        <div class="col-span-3">{{$event->cost}}</div>
    </div>
@endif

{{-- event description EN --}}
<div class="info">
    <div class=''>Description (English)</div>
    <div class='col-span-3'>{!!$event->description_en!!}</div>
</div>

{{-- event description JA --}}
<div class="info">
    <div>Description (Japanese)</div>
    <div class="cols-span-3">{!! $event->description_ja!!}</div>
</div>

{{-- event status --}}
<div class="info">
    <div>Status</div>
    <div class='uppercase font-bold col-span-3'>{{$event->publish_status}}</div>
</div>

{{-- event topic --}}
<div class="info">
    <div>Topic</div>
    <div class="col-span-3">
        @if($event->topic)
            <a href="{{route('topic.show',$event->topic->id)}}" class="link">{{ $event->topic->name}}</a>
        @else
            <div class='italic text-gray-500'>
                No Topic Set
            </div>
        @endif
    </div>
</div>

{{-- event location --}}
<div class="info">
    <div>Location</div>
    <div class="col-span-3">
        @if($event->location)
            <a href="{{route('location.show',$event->location->id)}}" class="link">{{ $event->location->name}}</a>
        @else
            <div class='italic text-gray-500'>
                No Location Set
            </div>
        @endif
    </div>
</div>

{{-- event author and last update --}}
<div class="info">
    <div>Author</div>
    <div><a href="{{route('user.show',$event->user->id)}}" class="link">{{ $event->user->name}}</a></div>
    <div>Last Update</div>
    <div>{{ $event->updated_at }}</div>
</div>
