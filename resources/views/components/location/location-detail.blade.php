@props(['location'])

<div class='info'>
    <div>Name</div>
    <div>
        {{$location->name}}
    </div>
</div>

<div class='info'>
    <div>Description (English)</div>
    <div>
        {{$location->description_en}}
    </div>
</div>

<div class='info'>
    <div>Description (Japanese)</div>
    <div>
        {{$location->description_ja}}
    </div>
</div>

<div class='info'>
    <div>GPS-Long</div>
    <div>
        {{$location->gps_long}}
    </div>
</div>

<div class='info'>
    <div>GPS-Lat</div>
    <div>
        {{$location->gps_lat}}
    </div>
</div>

<div class='info'>
    <div>Website URL</div>
    <div>
        {{$location->website_url}}
    </div>
</div>

<div class='info'>
    <div>Cost</div>
    <div>
        {{$location->cost}}
    </div>
</div>


<div class="info">
<div>Author</div>
<div><a href='{{route("user.show", $location->user->id)}}' class="hover:text-blue-500 cursor-pointer">{{ $location->user->name}}</a></div>
<div>Last Update</div>
<div>{{$location->updated_at}}</div>
</div>
</div>
