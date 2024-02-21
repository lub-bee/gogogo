<x-admin-layout>

    <div class='section flex justify-between'>
        <a href={{ route('event.index')}} class="btn">Back</a>
        <a href={{ route('event.edit', $event->id)}} class="btn">Edit</a>
    </div>

    <div class='section'>
        <div class='container p-4'>

            <div class='info'>
                <div>Name</div>
                <div >
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
                <div>Author</div>
                <div><a href={{route('user.show',$event->user->id)}}>{{ $event->user->name}}</a></div>
                <div>Last Update</div>
                <div>{{ $event->updated_at }}</div>
            </div>

        </div>
    </div>

</x-admin-layout>
