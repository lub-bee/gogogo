@props(['location'])

{{-- location name --}}
<div class='info'>
    <div>Name</div>
    <div>{{$location->name}}</div>
</div>

{{-- location description --}}
<div class='info'>
    <div>Description</div>
    <div>{{ $location->description_en }}</div>
</div>

{{-- gps --}}
@if($location->gps_long || $location->gps_lat)
    <div class='info'>
        {{-- gps long --}}
        @if($location->gps_long)
            <div>GPS-Long</div>
            <div>{{$location->gps_lat}}</div>
        @endif

        {{-- gps lat --}}
        @if($location->gps_lat)
            <div>GPS-Lat</div>
            <div>{{$location->gps_long}}</div>
        @endif
    </div>
@endif

{{-- website --}}
@if ($location->website_url)
    <div class='info'>
        <div>Website URL</div>
        <div>{{$location->website_url}}</div>
    </div>
@endif

{{-- cost --}}
<div class='info'>
    <div>Cost</div>
    <div>{{$location->cost}}</div>
</div>

{{-- author and last update --}}
<div class="info">
    {{-- author --}}
    <div>Author</div>
    <div><a href='{{route("user.show", $location->user->id)}}' class="hover:text-blue-500 cursor-pointer">{{ $location->user->name}}</a></div>

    {{-- last update --}}
    <div>Last Update</div>
    <div>{{$location->updated_at}}</div>
</div>
