{{--
    Management area layout — admin/support back office.
    Sidebar navigation with slate palette, functional over fancy.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Management' }} — {{ config('app.name', 'GoGoGo') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-800">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

        {{-- Sidebar --}}
        <aside class="hidden md:flex md:w-56 md:flex-col md:fixed md:inset-y-0 z-30">
            <div class="flex flex-col flex-1 bg-slate-800 text-white">
                {{-- Logo / brand --}}
                <a href="{{ route('management.dashboard') }}" class="flex items-center h-14 px-4 bg-slate-900 text-lg font-bold uppercase tracking-widest">
                    <i class="fa-solid fa-gear fa-fw mr-2 text-sm text-slate-400"></i>GoGoGo
                </a>

                {{-- Nav links --}}
                <nav class="flex-1 px-2 py-4 space-y-1">
                    <x-management.nav-item route="management.dashboard" icon="fa-tachometer-alt" label="Dashboard" />
                    <x-management.nav-item route="management.events.index" icon="fa-calendar-days" label="Events" />
                    <x-management.nav-item route="management.topics.index" icon="fa-book-open" label="Topics" />
                    <x-management.nav-item route="management.locations.index" icon="fa-map-marker-alt" label="Locations" />
                    <x-management.nav-item route="management.media" icon="fa-images" label="Media" />
                    @if(auth()->user()->isAdmin())
                        <x-management.nav-item route="management.users.index" icon="fa-users" label="Users" />
                    @endif

                    {{-- Back to public site --}}
                    <div class="border-t border-slate-700 mt-4 pt-4">
                        <a href="{{ route('top') }}" class="flex items-center px-3 py-2 rounded text-sm font-bold uppercase tracking-widest text-slate-400 hover:bg-slate-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-arrow-left fa-fw mr-2 text-xs"></i>Back to site
                        </a>
                    </div>
                </nav>

                {{-- User footer --}}
                <div class="px-4 py-3 bg-slate-900 border-t border-slate-700">
                    <div class="text-sm font-medium truncate">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-400 uppercase tracking-widest">{{ Auth::user()->rank }}</div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="text-xs text-slate-400 hover:text-white uppercase tracking-widest transition-colors">
                            <i class="fa-solid fa-right-from-bracket fa-fw mr-1"></i>Log out
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Mobile header --}}
        <div class="md:hidden fixed top-0 inset-x-0 z-30 bg-slate-800 text-white h-14 flex items-center justify-between px-4">
            <a href="{{ route('management.dashboard') }}" class="text-lg font-bold uppercase tracking-widest">
                <i class="fa-solid fa-gear fa-fw mr-1 text-sm text-slate-400"></i>GoGoGo
            </a>
            <button @click="sidebarOpen = !sidebarOpen" class="text-slate-300 hover:text-white">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>

        {{-- Mobile sidebar overlay --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200" x-transition:leave="transition-opacity duration-200"
             class="md:hidden fixed inset-0 z-40 bg-slate-900/50" @click="sidebarOpen = false" style="display:none;"></div>
        <div x-show="sidebarOpen" x-transition:enter="transition-transform duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition-transform duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
             class="md:hidden fixed inset-y-0 left-0 z-50 w-56 bg-slate-800 text-white flex flex-col" style="display:none;">
            <div class="flex items-center h-14 px-4 bg-slate-900 text-lg font-bold uppercase tracking-widest">
                <i class="fa-solid fa-gear fa-fw mr-2 text-sm text-slate-400"></i>GoGoGo
            </div>
            <nav class="flex-1 px-2 py-4 space-y-1">
                <x-management.nav-item route="management.dashboard" icon="fa-tachometer-alt" label="Dashboard" />
                <x-management.nav-item route="management.events.index" icon="fa-calendar-days" label="Events" />
                <x-management.nav-item route="management.topics.index" icon="fa-book-open" label="Topics" />
                <x-management.nav-item route="management.locations.index" icon="fa-map-marker-alt" label="Locations" />
                <x-management.nav-item route="management.media" icon="fa-images" label="Media" />
                @if(auth()->user()->isAdmin())
                    <x-management.nav-item route="management.users.index" icon="fa-users" label="Users" />
                @endif

                {{-- Back to public site --}}
                <div class="border-t border-slate-700 mt-4 pt-4">
                    <a href="{{ route('top') }}" class="flex items-center px-3 py-2 rounded text-sm font-bold uppercase tracking-widest text-slate-400 hover:bg-slate-700 hover:text-white transition-colors">
                        <i class="fa-solid fa-arrow-left fa-fw mr-2 text-xs"></i>Back to site
                    </a>
                </div>
            </nav>
            <div class="px-4 py-3 bg-slate-900 border-t border-slate-700">
                <div class="text-sm font-medium truncate">{{ Auth::user()->name }}</div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="text-xs text-slate-400 hover:text-white uppercase tracking-widest">
                        <i class="fa-solid fa-right-from-bracket fa-fw mr-1"></i>Log out
                    </button>
                </form>
            </div>
        </div>

        {{-- Main content --}}
        <div class="flex-1 md:ml-56">
            <main class="pt-14 md:pt-0 min-h-screen">
                {{-- Page header --}}
                @isset($heading)
                    <div class="bg-slate-700 text-white px-4 md:px-8 py-4">
                        <div class="max-w-7xl mx-auto flex items-center justify-between">
                            <div class="text-2xl md:text-4xl font-bold uppercase -tracking-[0.06em]">
                                {{ $heading }}
                            </div>
                            @isset($headingActions)
                                <div>{{ $headingActions }}</div>
                            @endisset
                        </div>
                    </div>
                @endisset

                {{-- Flash messages --}}
                <div class="max-w-7xl mx-auto px-4 md:px-8">
                    @if(session('status'))
                        <div class="mt-4 bg-green-100 text-green-700 px-4 py-2 rounded text-sm uppercase tracking-widest font-bold">
                            <i class="fa-solid fa-check mr-1"></i>{{ session('status') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mt-4 bg-red-100 text-red-700 px-4 py-2 rounded text-sm uppercase tracking-widest font-bold">
                            <i class="fa-solid fa-triangle-exclamation mr-1"></i>{{ session('error') }}
                        </div>
                    @endif
                </div>

                {{-- Page body --}}
                <div class="max-w-7xl mx-auto px-4 md:px-8 py-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>
