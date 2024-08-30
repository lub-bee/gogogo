<x-public-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot> --}}

    <x-front.section id="profile-top" class="bg-white lg:grid lg:grid-cols-2 flex flex-col text-slate-700 h-screen">
        <div class='flex-1'>
            <div class='text-slate-700 title'>
                Public
            </div>
            <div class='m-4 lg:m-10 space-y-4 lg:space-y-8 text-2xl lg:text-3xl'>

                <div class=''>
                    <div class='uppercase'>
                        Pseudo
                    </div>
                    <div class='text-4xl lg:text-6xl mx-10'>
                        {{ Auth::user()->name }}
                    </div>
                </div>

                <div class=''>
                    <div class='uppercase'>
                        Registered since
                    </div>
                    <div class='text-4xl lg:text-6xl mx-10'>
                        {{ Auth::user()->created_at->format('Y-m-d') }}
                    </div>
                </div>

                <div class=''>
                    <div class='uppercase'>
                        Media published
                    </div>
                    <div class='text-4xl lg:text-6xl mx-10'>
                        {{ Auth::user()->medias()->count() }}
                    </div>
                </div>

            </div>
        </div>
        <div class='bg-slate-700 text-slate-300 flex-1'>
            <div class='text-white title'>
                Private
            </div>
            <div class='m-4 lg:m-10 space-y-4 lg:space-y-8 text-2xl lg:text-3xl'>
                <div class=''>
                    <div class='uppercase'>
                        Email
                    </div>
                    <div class='text-4xl lg:text-6xl mx-10'>
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class='flex flex-col'>
                    <a href="#profile-media" class="btn btn-success px-4 py-2 lg:p-4 pl-0 hover:pl-4">
                        {{-- <i class='fa-solid fa-image fa-fw opacity-0 group-hover:opacity-100 scale-x-0 group-hover:scale-x-100 transition-all'></i> --}}
                        My Media
                    </a>
                    <a href="#profile-info" class="btn btn-main px-4 py-2 lg:p-4 pl-0 hover:pl-4">
                        {{-- <i class='fa-solid fa-address-card text-white fa-fw'></i> --}}
                        Edit info
                    </a>
                    <a href="#profile-password" class="btn btn-main px-4 py-2 lg:p-4 pl-0 hover:pl-4">
                        {{-- <i class='fa-solid fa-asterisk text-white fa-fw'></i> --}}
                        Edit PASSWORD
                    </a>
                    <a href="#profile-delete" class="btn btn-danger px-4 py-2 lg:p-4 pl-0 hover:pl-4">
                        {{-- <i class='fa-solid fa-trash text-white fa-fw'></i> --}}
                        Deletion
                    </a>
                </div>
            </div>
        </div>
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
