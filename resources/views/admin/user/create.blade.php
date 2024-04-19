<x-admin-layout>

    <div class='section'>
        <a href={{route("user.index")}} class="btn">Back</a>
    </div>

    <div class='section'>
        <div class='block-container p-4'>

            <div class='title-1'>
                User creation
            </div>

            <form method="POST" action="{{route('user.store')}}">
                @csrf

                <div class="info">
                    <div>Pseudo <x-required/></div>
                    <div class='col-span-3'>
                        <input type="text" class="form-input"  name="name" value='{{old("name")}}'>
                        @error("name")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Email <x-required/></div>
                    <div class='col-span-3'>
                        <input type="text" class="form-input" name="email" value='{{old("email")}}'>
                        @error("email")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Password <x-required/></div>
                    <div class=''>
                        <input type="password" class="form-input" name="password" value='{{old("password")}}'>
                        @error("password")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                    <div>Password Confirmation<x-required/></div>
                    <div class=''>
                        <input type="password" class="form-input" name="password_confirmation" value='{{old("password_confirmation")}}'>
                        @error("password_confirmation")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="info">
                    <div>Rank <x-required/></div>
                    <div class='col-span-3'>
                        <select class="form-input" name="rank">
                            @foreach(App\Models\User::RANKS as $rank)
                                <option value="{{$rank}}" {{old("rank") == $rank ? 'selected' : ''}}>
                                    {{App\Models\User::rankLabel($rank)}}
                                </option>
                            @endforeach
                        </select>
                        @error("rank")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-5">
                    <a class="btn" href="{{ route('user.index') }}">
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
