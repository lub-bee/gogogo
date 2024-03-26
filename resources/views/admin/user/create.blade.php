<x-admin-layout>

    <div class='section'>
        <a href={{route("user.index")}} class="btn">Back</a>
    </div>

    <div class='section'>
        <div class='block-container p-4'>
            <form method="POST" action={{route('user.store')}}>
                @csrf

                <div>
                    <label>User Name (Required) </label>
                    <br>
                    <input type="text" name="name" value={{old("name")}}>
                    @error("name")
                        <div>{{$message}}</div>
                    @enderror
                </div>

                <div>
                    <label>Email (Required) </label>
                    <br>
                    <input type="text" name="email" value={{old("email")}}>
                    @error("email")
                        <div>{{$message}}</div>
                    @enderror
                </div>

                <div class="flex justify-center gap-4 mt-5">
                    <a class="btn" href={{ route('user.index') }}>
                        CANCEL
                    </a>
                    <button type="submit" class="btn btn-main">
                        SAVE
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
