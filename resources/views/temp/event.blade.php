{{$event->name}}<br/>
{{$event->description_en}}<br/>
{{$event->description_ja}}<br/>
{{$event->start_at}}<br/>


{{$event->topic->name}}<br/>
{{$event->topic->description_en}}<br/>
{{$event->topic->description_ja}}<br/>
{{$event->topic->id}}<br/>


{{$event->location->name}}<br/>
{{$event->location->website_url}}<br/>
{{$event->location->gps_lat}}<br/>
{{$event->location->gps_long}}<br/>

@if($event->medias->count() > 0)
    @foreach($event->medias as $media)
        {{$media->path_url}}<br/>
    @endforeach
@endif


