@props(['event'])

<form method="POST" action="{{ route('event.destroy') }}" >
    @csrf
    @method("delete")
    <div class='section'>
        <div class='block-container p-4 '>

            <input type="hidden" name="event_id" value="{{$event->id}}" />

            <div class="text-xl">
                Delete the event
            </div>
            <button type="submit" class="btn btn-danger">Delete</button>
        </div>
    </div>
</form>
