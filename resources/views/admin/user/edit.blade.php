<x-admin-layout>

    <div class='section'>
        <h1>User edition</h1>
    </div>

    <div class='section'>
        <a href="{{ route('user.show', $user->id)}}" class="btn">Back</a>
    </div>

    <div class='section'>
        <div class='block-container p-4 '>

            <form method="POST" action="{{route('user.update',  $user->id)}}">
                @csrf
                @method('PUT')

                <div class="info">
                    <div>User Name <x-required/></div>
                    <div class='col-span-3'>
                        <x-input-error :messages="$errors->get('name')" class="mb-2" />
                        <input type="text" name="name" class="form-input" value="{{old('name',$user->name)}}">
                    </div>
                </div>

                <div class="info">
                    <div>Email <x-required/></div>
                    <div class='col-span-3'>
                        <x-input-error :messages="$errors->get('email')" class="mb-2" />
                        <input type="text" name="email" class="form-input" value="{{old('email',$user->email)}}">
                    </div>
                </div>

                {{--
                <div class="info">
                    <div>Password <x-required/></div>
                    <div class=''>
                        <input type="password" class="form-input" name="password" value=''>
                        @error("password")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                    <div>Password Confirmation<x-required/></div>
                    <div class=''>
                        <input type="password" class="form-input" name="password_confirmation" value=''>
                        @error("password_confirmation")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div> --}}

                <div class="info">
                    <div>Rank <x-required/></div>
                    <div class='col-span-3'>
                        <x-input-error :messages="$errors->get('rank')" class="mb-2" />
                        <select class="form-input" name="rank">
                            @foreach(App\Models\User::RANKS as $rank)
                                <option value="{{$rank}}" {{old("rank") == $rank ? 'selected' : ''}}>
                                    {{App\Models\User::rankLabel($rank)}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                {{-- <div class="mt-4 info">
                    <div>Password Confirmation<x-required/></div>
                    <div class='col-span-3'>
                        <input type="password" class="form-input" name="password" value=''>
                        @error("password")
                            <div>{{$message}}</div>
                        @enderror
                    </div>
                </div> --}}

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
        <div class="block-container p-4">
            <div class=''>
                Delete the user
            </div>
            <a href="{{ route('user.destroy', $user->id)}}" class="btn btn-danger">
                Delete
            </a>
        </div>
    </div>

</x-admin-layout>
