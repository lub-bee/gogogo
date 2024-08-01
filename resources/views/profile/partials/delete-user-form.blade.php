<div class="text-white p-4 max-w-5xl mx-auto">
    <div class='text-4xl mt-20 uppercase'>
        Ouhhh, you are sure about that?<br/> Once deleted, there is no way back, so be careful.
    </div>

    <div class='text-2xl mt-8 uppercase'>
        Please enter your password to confirm the permanent deletion of your account.
    </div>

    <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Confirm with your Password') }}" class="uppercase text-white" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            {{-- <div class="mt-6 flex justify-end"> --}}
                {{-- <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button> --}}

                <button type="submit" class="btn mt-10">
                    {{ __('Delete Account') }}
                </button>
            {{-- </div> --}}
        </form>
    </div>
</section>
