<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512- overposting" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


        <!-- Quill -->
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.snow.css"rel="stylesheet"/>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @if(session()->has("success"))
                <div class='mt-8 max-w-7xl mx-auto sm:px-6 lg:px-8 text-right mb-0'>
                    <div class=" border-blue-500 text-blue-500 text-4xl uppercase font-bold px-4">
                        <i class='far fa-lightbulb'></i> {{ session('success')}}
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="px-5 py-8">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
