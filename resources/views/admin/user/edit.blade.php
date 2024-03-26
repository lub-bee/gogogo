<x-admin-layout>

    <div class='section'>
        <a href="{{ route('user.show', $user->id)}}" class="btn">Back</a>
    </div>

    <div class='section'>
        <div class='block-container p-4 '>

            <form method="POST" action="{{route('user.update',  $user->id)}}">
                @csrf
                @method('PUT')

                <div class="info">
                    <div>User Name (Required) </div>
                    <div>
                        <input type="text" name="name" value="{{old('name',$user->name)}}">
                        @error("name")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Email (Required) </div>
                    <div>
                        <input type="text" name="email" value="{{old('email',$user->email)}}">
                        @error("email")
                        <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex mt-5 gap-4 justify-center">
                    <a href="{{ route('user.show', $user->id)}}" class="btn">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-main">
                        Edit
                    </button>

                </div>

            </form>
        </div>
    </div>

    <div class="section">
        <div class="block-container">
            <a href="{{ route('user.destroy', $user->id)}}" class="btn">
                Delete
            </a>
        </div>
    </div>

</x-admin-layout>
