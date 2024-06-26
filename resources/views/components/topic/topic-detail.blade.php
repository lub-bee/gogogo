@props(['topic'])

{{-- name --}}
<div class='info'>
    <div>Name</div>
    <div>{{$topic->name}}</div>
</div>

{{-- memo --}}
@if ($topic->memo)
    <div class='info'>
        <div>Memo</div>
        <div>{{$topic->memo}}</div>
    </div>
@endif

{{-- content EN (formated)--}}
<div class="info">
    <div>Content (EN)</div>
    <div class='formated-content col-span-3'>{!! $topic->description_en !!}</div>
</div>

{{-- content EN (formated) --}}
<div class="info">
    <div>Content (JA)</div>
    <div class='formated-content col-span-3'>{!! $topic->description_ja !!}</div>
</div>

{{-- author --}}
<div class="info">
    <div>Author</div>
    <div><a href="{{route('user.show',$topic->user->id)}}" class="hover:text-blue-500 cursor-pointer" class="link">{{ $topic->user->name}}</a></div>
</div>

{{-- status --}}
<div class="info">
    <div>Status</div>
    <div>{{ $topic->publish_status }}</div>

    @if ($topic->isPublished())
        <div>Published at</div>
    @endif

    @if($topic->isScheduled())
        <div>Scheduled at</div>
    @endif

    @if( $topic->isPublished() || $topic->isScheduled())
        <div>{{ $topic->published_at }}</div>
    @endif
</div>

{{-- created_at, updated_at --}}
<div class="info">
    <div>Created at</div>
    <div>{{ $topic->created_at }}</div>
    <div>Last Update</div>
    <div>{{ $topic->updated_at }}</div>
</div>
