@props(['location'])

<form method="POST" action="{{ route('location.destroy', $location->id) }}">
    @csrf
    @method('DELETE')
    <input type="hidden" name="location_id" value="{{$location->id}}" />

    <div class='section'>
        <div class='block-container p-4 '>
            <div class=''>
                Delete the location
            </div>

            <input type="submit" value="Delete" class="btn btn-danger">

        </div>
    </div>

</form>
