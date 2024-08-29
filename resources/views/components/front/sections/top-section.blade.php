@props ([
    "greetings" => "Hello there,",
])
<div class='flex-1 h-screen flex flex-col lg:flex-row overflow-hidden'>

    {{-- animated logo - Todo --}}
    <div class='flex-1 text-[5rem] sm:text-[9rem] font-bold flex justify-center items-center text-slate-700'>
        五語Go!
    </div>

    {{-- side menu --}}
    <div class='flex-1 lg:flex-none lg:w-1/3 lg:max-w-[400px] lg:bg-gray-300'>

        {{-- login form --}}
        @auth

            <div class='flex flex-col items-start lg:p-4 gap-4 h-full lg:h-auto' x-data="{mode: 'default'}">
                <div class='text-2xl text-slate-700 bold px-4 lg:p-0 self-center'>
                    {{ $greetings }} {{ Auth::user()->name }}
                </div>

                <div class='self-end lg:self-stretch flex-1 bg-gray-200 lg:bg-transparent pr-10 lg:pr-0'>
                    @if(auth()->user()->isAdmin())
                        <a class='top-menu-link long hover:text-orange-500' href="{{ route('dashboard') }}" x-show="mode === 'default'">
                            Dashboard
                        </a>
                    @endif
                    <div :class='mode === "discord" ? "top-menu-link discord active" : "top-menu-link discord"' @click='mode != "discord" ? mode = "discord" : mode = "default"' x-show='mode === "default" || mode === "discord"'>
                        Discord
                    </div>
                    <div :class='mode === "line" ? "top-menu-link line active" : "top-menu-link line"' @click='mode != "line" ? mode = "line" : mode = "default"' x-show='mode === "default" || mode === "line"'>
                        Line
                    </div>
                    <a class='top-menu-link hover:text-slate-500' href="{{ route('profile.edit') }}" x-show="mode === 'default'">
                        Profile
                    </a>
                    <a class='top-menu-link hover:text-red-500' href="{{ route('logout') }}" x-show="mode === 'default'">
                        Logout
                    </a>
                </div>

                {{-- <div class='self-stretch text-4xl text-slate-700 flex gap-4 justify-center'>
                    <div :class="mode === 'default' ? 'btn-sns selected' : 'btn-sns'" title="Welcome home!" @click="mode = 'default'">
                        <i class='fas fa-house fa-fw'></i>
                    </div>
                    <div :class="mode === 'discord' ? 'btn-sns selected' : 'btn-sns'" title="Join us on Discord" @click="mode = 'discord'">
                        <i class='fab fa-discord fa-fw'></i>
                    </div>
                    <div :class="mode === 'line' ? 'btn-sns selected' : 'btn-sns'" title="Join us on LINE" @click="mode = 'line'">
                        <i class='fab fa-line fa-fw'></i>
                    </div>
                    <a href="{{ route('logout') }}" class="btn-sns-red" title="Logout">
                        <i class='fas fa-right-from-bracket fa-fw'></i>
                    </a>
                </div> --}}


                <div class='absolute lg:static bottom-0 left-0 right-0 top-0 p-4 self-stretch flex flex-col h-screen lg:h-auto bg-white lg:bg-transparent' x-show="mode === 'discord'" x-cloak>
                    <div class='top-menu-title flex justify-between hover:text-blue-500 hover:tracking-tight group lg:hidden mb-10' @click='mode = "default"'>
                        <div class=''>
                            Discord
                        </div>
                        <div class=''>
                            <i class='fa-solid fa-xmark fa-fw group-hover:rotate-90 group-active:rotate-90 transition-all'></i>
                        </div>
                    </div>
                    <div class='h-12 bg-slate-700 border border-slate-400 rounded-lg self-stretch text-slate-200 flex justify-center items-center'>
                        discord invitation
                    </div>
                    <iframe src="https://discord.com/widget?id=1184014491579588618" class="h-60 w-full" allowtransparency="false" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
                </div>


                <div class='self-stretch flex flex-col' x-show="mode === 'line'" x-cloak>
                    <div class='h-12 bg-slate-700 border border-slate-400 rounded-lg self-stretch text-slate-200 flex justify-center items-center'>
                        line invitation
                    </div>
                    <div class='h-60 w-full bg-slate-700 border border-slate-400 rounded-lg self-stretch text-slate-200 flex justify-center items-center'>
                        line invitation
                    </div>
                </div>

                {{--
                <div class='self-stretch flex flex-col mt-10 gap-4' x-show="mode === 'default'" x-cloak>
                    <a href="{{ route('dashboard') }}" class='btn btn-main'>Go to Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class='btn btn-main'>Go to Profile</a>
                </div> --}}
            </div>
        @else
            <form method="POST" action="{{ route('login') }}" class="h-full flex flex-col gap-4 p-4 justify-center sm:max-w-sm lg:max-w-full mx-auto bg-slate-200 lg:bg-transparent">
                @csrf
                <div class='flex justify-between items-center border-b border-gray-400 mb-4 md:mt-8 uppercase text-slate-700'>
                    Not a member yet? <a href="{{ route('register') }}" class='btn btn-success'>Join us!</a>
                </div>
                <div class=''>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    <input type="email" name="email" placeholder="email" class="form-input" autocomplete="username"/>
                </div>
                <div class=''>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    <input type="password" name="password" placeholder="password" class="form-input" required autocomplete="current-password"/>
                </div>
                <div class='text-right'>
                    <a href="{{ route('password.request') }}" class="text-slate-700 hover:underline">You have forgot your password?</a>
                </div>
                <div class='text-center'>
                    <button type="submit" class="btn btn-main">{{ __('sign in') }}</button>
                </div>
            </form>
        @endauth

    </div>
</div>
<div class='flex-none h-4 bg-slate-700'></div>
