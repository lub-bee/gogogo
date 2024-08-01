<x-public-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot> --}}

    <x-front.section id="top" class="bg-white flex flex-col text-slate-700">
        <div class='flex-1 flex justify-center gap-20'>
            <div class='w-1/3 self-center flex flex-col justify-center border-8'>
                <div class='text-6xl font-bold -tracking-[0.12em] bg-slate-200'>
                    PUBLIC
                </div>
                <div class='uppercase px-4'>
                    Pseudo
                </div>
                <div class='text-right text-3xl px-4'>
                    {{ Auth::user()->name }}
                </div>
                <div class='border-t-8 uppercase px-4'>
                    Registered since
                </div>
                <div class='text-right text-3xl px-4'>
                    {{ Auth::user()->created_at->format('Y-m-d') }}
                </div>

                <div class='border-t-8 uppercase px-4'>
                    Media published
                </div>
                <div class='text-right text-3xl px-4'>
                    {{ Auth::user()->medias()->count() }}
                </div>

                <div class='border-t-8 uppercase px-4'>
                    Participations
                </div>
                <div class='text-right text-3xl px-4'>
                    n
                </div>
            </div>

            <div class='w-1/3 self-center flex flex-col justify-center border-8 border-slate-200'>
                <div class='text-6xl font-bold -tracking-[0.12em] bg-slate-200'>
                    PRIVATE
                </div>
                <div class='uppercase px-4'>
                    Email
                </div>
                <div class='text-right text-2xl px-4 -tracking-[0.06em]'>
                    {{-- {{ Auth::user()->email }} --}}ludovic.blervaque@lubbee.net
                </div>
                <div class='flex flex-col border-t-8 p-4 text-right'>
                    <a href="#profile-media" class="btn btn-success"><i class='fa-solid fa-image text-white'></i>&nbsp; Media</a>
                    <a href="#profile-info" class="btn btn-main"><i class='fa-solid fa-address-card text-white'></i>&nbsp; Edit info</a>
                    <a href="#profile-password" class="btn btn-main"><i class='fa-solid fa-asterisk text-white'></i>&nbsp; Edit PWD</a>
                    <a href="#profile-delete" class="btn btn-danger"><i class='fa-solid fa-trash text-white'></i>&nbsp; Deletion</a>
                </div>

            </div>

        </div>
        <div class='flex-none h-4 bg-slate-700'></div>
    </x-front.section>

    <x-front.section id="profile-media" class="bg-white">
        <header class='bg-slate-700 text-white'>
            My Media
        </header>

        Todo

    </x-front.section>

    <x-front.section id="profile-info" class="bg-slate-700">
        <header class='bg-white text-slate-700'>
            My Info
        </header>
        @include('profile.partials.update-profile-information-form')
    </x-front.section>

    <x-front.section id="profile-password" class="bg-white">
        <header class='bg-slate-700 text-white'>
            My Password
        </header>

        @include('profile.partials.update-password-form')
    </x-front.section>

    <x-front.section id="profile-delete" class="bg-red-400">
        <header class='bg-white text-red-500'>
            My Account
        </header>
        @include('profile.partials.delete-user-form')
    </x-front.section>

</x-public-layout>
