@props ([
    "greetings" => "Hello there,",
])
<div class='flex-1 flex flex-col lg:flex-row'>

    {{-- animated logo - Todo --}}
    <div class='flex-1 text-[5rem] sm:text-[9rem] font-bold flex justify-center items-center text-slate-700'>
        五語Go!
    </div>

    {{-- side menu --}}
    <div class='lg:w-1/3 lg:max-w-[400px] flex-none bg-gray-300'>

        {{-- login form --}}
        @auth
            {{--  --}}
            <div class='flex flex-col items-start p-4 gap-4' x-data="{mode: 'default'}">
                <div class='text-2xl text-slate-700 bold'>
                    {{ $greetings }} {{ Auth::user()->name }}
                </div>

                <div class='self-stretch text-4xl text-slate-700 flex gap-4 justify-center'>
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
                </div>


                <div class='self-stretch flex flex-col' x-show="mode === 'discord'" x-cloak>
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


                <div class='self-stretch flex flex-col' x-show="mode === 'default'" x-cloak>
                    Something here, maybe?
                </div>
            </div>
        @else
            <form method="POST" action="{{ route('login') }}" class="h-full flex flex-col gap-4 p-4 justify-center sm:max-w-sm lg:max-w-full mx-auto">
                @csrf
                <div class='flex justify-between items-center border-b border-gray-400 mb-4 md:mt-8 uppercase'>
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
