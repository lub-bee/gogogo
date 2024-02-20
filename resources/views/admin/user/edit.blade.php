<x-admin-layout>
    <h1 class="font-sans text-red-300 antialiased">
        Create User
    </h1>

    <form method="POST" action={{route('user.update')}}>
        @method("PUT")

        @csrf

        <div>
            <label>User Name</label>
            <br>
            <input type="text" name="name" value="{{old("name")}}"/>
            @error("name")
                <div>{{$message}}</div>
            @enderror
        </div>

        <div>
            <label>Email</label>
            <br>
            <input type="text" name="email" value="{{old("email")}}"/>
            @error("email")
                <div>{{$message}}</div>
            @enderror
        </div>
            {{--
            REGISTERING A NEW USER - SEPARATE LARAVEL SYSTEM?
            HASH - TO HIDE PASSWORD?

            --}}

        <div>
            <button type="submit">
                UPDATE
            </button>
        </div>
    </form>
</x-admin-layout>
