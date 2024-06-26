<x-admin-layout>

    <div class='section'>
        <h1>User create</h1>
    </div>

    {{-- nav --}}
    <div class='section'>
        <a href={{route("user.index")}} class="btn">Back</a>
    </div>

    {{-- form --}}
    <div class='section'>
        <div class='block-container p-4'>

            <form method="POST" action="{{route('user.store')}}">
                @csrf

                {{-- name --}}
                <div class="info">
                    <div>Displayed Name <x-required/></div>
                    <div class='col-span-3'>
                        <x-input-error :messages="$errors->get('name')" class="mb-2" />
                        <input type="text" class="form-input"  name="name" value='{{old("name")}}'>
                    </div>
                </div>

                {{-- email --}}
                <div class="info">
                    <div>Email <x-required/></div>
                    <div class='col-span-3'>
                        <x-input-error :messages="$errors->get('email')" class="mb-2" />
                        <input type="text" class="form-input" name="email" value='{{old("email")}}'>
                    </div>
                </div>

                {{-- password, password confirmation --}}
                <div class="info">

                    {{-- password --}}
                    <div>Password <x-required/></div>
                    <div class=''>
                        <x-input-error :messages="$errors->get('password')" class="mb-2" />
                        <input type="password" class="form-input" name="password" value='{{old("password")}}'>
                    </div>

                    {{-- password confirmation --}}
                    <div>Password Confirmation <x-required/></div>
                    <div class=''>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mb-2" />
                        <input type="password" class="form-input" name="password_confirmation" value='{{old("password_confirmation")}}'>
                    </div>
                </div>

                {{-- rank --}}
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
