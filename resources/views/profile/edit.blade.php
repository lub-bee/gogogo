{{--
    Profile area — snap-scroll sequence of fullscreen sections.
    Sections: Overview → My Media → My Info → My Password → My Account
--}}

<x-layouts.public
    :menuItems="['profile-top', 'profile-media', 'profile-info', 'profile-pwd', 'profile-account']"
    :menuLabels="['Profile', 'My Media', 'My Info', 'My Pwd', 'My Account']"
    :menuBack="['url' => url('/'), 'label' => 'Back']"
    title="Profile — GoGoGo">

    <main class="top relative h-screen snap-y snap-mandatory overflow-y-auto scroll-smooth">

        {{-- ===== SECTION 1: PROFILE OVERVIEW ===== --}}
        <section id="profile-top" class="top-section bg-slate-700 text-white flex flex-col">
            <x-front.section-header bg="bg-white" text="text-slate-700">Profile</x-front.section-header>

            <div class="flex-1 flex flex-col justify-center max-w-6xl mx-auto w-full px-4 md:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 divide-y-4 lg:divide-y-0 lg:divide-x-4 divide-slate-500 gap-0">

                    {{-- PUBLIC half --}}
                    <div class="py-8 lg:py-0 lg:pr-12 flex flex-col justify-center gap-6 md:gap-8">
                        <div class="text-xs uppercase tracking-[0.2em] text-slate-400 font-bold">
                            Public <span class="text-slate-500 ml-2">公開</span>
                        </div>

                        <div>
                            <div class="text-xs uppercase tracking-[0.15em] text-slate-400 font-bold">Pseudo</div>
                            <div class="text-[3rem] md:text-[5rem] lg:text-[6rem] leading-[3rem] md:leading-[4.5rem] lg:leading-[5.5rem] font-bold uppercase -tracking-[0.12em]">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div>
                            <div class="text-xs uppercase tracking-[0.15em] text-slate-400 font-bold">Registered since</div>
                            <div class="text-[2rem] md:text-[3rem] leading-[2rem] md:leading-[3rem] font-bold -tracking-[0.08em]">
                                {{ $user->created_at->format('Y-m-d') }}
                            </div>
                        </div>

                        <div class="flex gap-8 md:gap-12">
                            <div>
                                <div class="text-xs uppercase tracking-[0.15em] text-slate-400 font-bold">Media published</div>
                                <div class="text-[3rem] md:text-[5rem] leading-[3rem] md:leading-[4.5rem] font-bold -tracking-[0.08em]">
                                    {{ $mediaCount }}
                                </div>
                            </div>
                            <div>
                                <div class="text-xs uppercase tracking-[0.15em] text-slate-400 font-bold">Participations</div>
                                <div class="text-[3rem] md:text-[5rem] leading-[3rem] md:leading-[4.5rem] font-bold -tracking-[0.08em]">
                                    {{ $attendanceCount }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PRIVATE half --}}
                    <div class="py-8 lg:py-0 lg:pl-12 flex flex-col justify-center gap-6 md:gap-8">
                        <div class="text-xs uppercase tracking-[0.2em] text-slate-400 font-bold">
                            Private <span class="text-slate-500 ml-2">非公開</span>
                        </div>

                        <div>
                            <div class="text-xs uppercase tracking-[0.15em] text-slate-400 font-bold">Email</div>
                            <div class="text-xl md:text-2xl font-light break-all">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 mt-2">
                            <a href="#profile-media" class="btn btn-success text-[1.5rem] md:text-[2rem] -tracking-[0.06em]">
                                <i class="fa-solid fa-images fa-fw text-base mr-2"></i>Media
                            </a>
                            <a href="#profile-info" class="btn btn-main text-[1.5rem] md:text-[2rem] -tracking-[0.06em]">
                                <i class="fa-solid fa-pen fa-fw text-base mr-2"></i>Edit info
                            </a>
                            <a href="#profile-pwd" class="btn btn-main text-[1.5rem] md:text-[2rem] -tracking-[0.06em]">
                                <i class="fa-solid fa-lock fa-fw text-base mr-2"></i>Edit pwd
                            </a>
                            <a href="#profile-account" class="btn btn-danger text-[1.5rem] md:text-[2rem] -tracking-[0.06em]">
                                <i class="fa-solid fa-triangle-exclamation fa-fw text-base mr-2"></i>Deletion
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ===== SECTION 2: MY MEDIA ===== --}}
        <section id="profile-media" class="top-section bg-white flex flex-col"
            x-data="{
                lightbox: false,
                lightboxBg: '',
                entered: false,
                open(bg) {
                    this.lightbox = true;
                    this.lightboxBg = bg;
                    this.entered = false;
                    this.$nextTick(() => { this.entered = true; });
                },
                close() {
                    this.entered = false;
                    setTimeout(() => { this.lightbox = false; this.lightboxBg = ''; }, 300);
                }
            }">
            <x-front.section-header bg="bg-slate-700" text="text-white">My Media</x-front.section-header>

            <div class="flex-1 flex flex-col justify-center max-w-6xl mx-auto w-full px-4 md:px-8 py-8">
                @if(count($userMedia) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 md:gap-4">
                    @foreach($userMedia as $media)
                        @php
                            $statusClass = match($media->status->value) {
                                'refused' => 'refused',
                                default => '',
                            };
                            $statusColor = match($media->status->value) {
                                'approved' => 'text-green-500',
                                'pending' => 'text-orange-500',
                                'refused' => 'text-white',
                            };
                            $statusLabel = match($media->status->value) {
                                'approved' => 'Accepted',
                                'pending' => 'Pending',
                                'refused' => 'Refused',
                            };
                            $bg = 'rgb(71 85 105)';
                        @endphp
                        <div class="profile-media-tile {{ $statusClass }} aspect-[4/3]"
                             style="background: {{ $bg }};"
                             @if($media->status->value !== 'refused')
                             @click="open('{{ $bg }}')"
                             @endif>
                            <div class="tile-icon"><i class="fa-solid fa-image"></i></div>
                            <div class="media-status-word {{ $statusColor }}">{{ $statusLabel }}</div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="text-2xl text-slate-400 uppercase font-light">No media uploaded yet</div>
                    <div class="text-lg text-slate-300 mt-2">まだメディアがアップロードされていません</div>
                </div>
                @endif
            </div>

            {{-- Lightbox --}}
            <div class="profile-lightbox-overlay"
                 x-show="lightbox"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click.self="close()"
                 style="display: none;">
                <div class="profile-lightbox-close" @click="close()">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="profile-lightbox-photo"
                     :style="'width: 70vw; height: 60vh; background: ' + lightboxBg + '; transform: scale(' + (entered ? '1' : '0.7') + '); opacity: ' + (entered ? '0.2' : '0')"
                     @click.stop>
                    <i class="fa-solid fa-image"></i>
                </div>
            </div>
        </section>

        {{-- ===== SECTION 3: MY INFO (EDIT) ===== --}}
        <section id="profile-info" class="top-section bg-slate-700 text-white flex flex-col">
            <x-front.section-header bg="bg-white" text="text-slate-700">My Info</x-front.section-header>

            <div class="flex-1 flex flex-col justify-center max-w-2xl mx-auto w-full px-4 md:px-8 py-8">

                <div class="text-lg md:text-xl uppercase font-bold -tracking-[0.04em] mb-2">
                    You are about to modify your profile information.
                </div>
                <div class="text-sm uppercase text-white mb-8 -tracking-[0.02em]">
                    プロフィール情報を変更しようとしています。
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="flex flex-col gap-6">
                    @csrf
                    @method('PATCH')

                    {{-- Name --}}
                    <div>
                        <label class="text-xs uppercase tracking-[0.15em] text-slate-400 font-bold mb-1 block">
                            Public name <span class="text-slate-500">表示名</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input w-full" />
                        @error('name')
                            <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="text-xs uppercase tracking-[0.15em] text-slate-400 font-bold mb-1 block">
                            Email <span class="text-slate-500">メール</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input w-full" />
                        @error('email')
                            <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Save --}}
                    <div class="mt-4 flex items-center gap-4">
                        <button type="submit" class="btn btn-main text-xl">Save</button>
                        @if(session('status') === 'profile-updated')
                            <span class="text-green-400 text-sm uppercase tracking-widest font-bold">Saved!</span>
                        @endif
                    </div>

                </form>
            </div>
        </section>

        {{-- ===== SECTION 4: MY PASSWORD ===== --}}
        <section id="profile-pwd" class="top-section bg-white text-slate-700 flex flex-col"
            x-data="{
                newPwd: '',
                get hasLength() { return this.newPwd.length >= 8; },
                get hasUpper() { return /[A-Z]/.test(this.newPwd); },
                get hasLower() { return /[a-z]/.test(this.newPwd); },
                get hasNumber() { return /[0-9]/.test(this.newPwd); }
            }">
            <x-front.section-header bg="bg-slate-700" text="text-white">My Password</x-front.section-header>

            <div class="flex-1 flex flex-col justify-center max-w-2xl mx-auto w-full px-4 md:px-8 py-8">

                <div class="text-lg md:text-xl uppercase font-bold -tracking-[0.04em] mb-2">
                    You are about to modify your password.
                </div>
                <div class="text-sm uppercase text-slate-500 mb-8 -tracking-[0.02em]">
                    パスワードを変更しようとしています。
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-xs uppercase tracking-[0.15em] text-slate-400 font-bold mb-1 block">
                            Current Password
                        </label>
                        <input type="password" name="current_password" class="form-input w-full" placeholder="current password" autocomplete="current-password" />
                        @error('current_password', 'updatePassword')
                            <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs uppercase tracking-[0.15em] text-slate-400 font-bold mb-1 block">
                            New Password
                        </label>
                        <input type="password" name="password" class="form-input w-full" placeholder="new password" x-model="newPwd" autocomplete="new-password" />
                        @error('password', 'updatePassword')
                            <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs uppercase tracking-[0.15em] text-slate-400 font-bold mb-1 block">
                            Confirm Password
                        </label>
                        <input type="password" name="password_confirmation" class="form-input w-full" placeholder="confirm password" autocomplete="new-password" />
                    </div>

                    {{-- Live password conditions checklist --}}
                    <div class="flex flex-col gap-1 mt-2">
                        <div class="text-xs uppercase tracking-[0.15em] text-slate-400 font-bold mb-2">
                            Password requirements
                        </div>
                        <div class="text-sm uppercase font-bold -tracking-[0.02em] transition-all duration-300"
                             :class="hasLength ? 'text-green-500' : 'text-slate-500'">
                            <i class="fa-solid fa-fw" :class="hasLength ? 'fa-check' : 'fa-circle text-[0.4rem] align-middle'"></i>
                            At least 8 characters
                        </div>
                        <div class="text-sm uppercase font-bold -tracking-[0.02em] transition-all duration-300"
                             :class="hasUpper ? 'text-green-500' : 'text-slate-500'">
                            <i class="fa-solid fa-fw" :class="hasUpper ? 'fa-check' : 'fa-circle text-[0.4rem] align-middle'"></i>
                            At least 1 uppercase letter
                        </div>
                        <div class="text-sm uppercase font-bold -tracking-[0.02em] transition-all duration-300"
                             :class="hasLower ? 'text-green-500' : 'text-slate-500'">
                            <i class="fa-solid fa-fw" :class="hasLower ? 'fa-check' : 'fa-circle text-[0.4rem] align-middle'"></i>
                            At least 1 lowercase letter
                        </div>
                        <div class="text-sm uppercase font-bold -tracking-[0.02em] transition-all duration-300"
                             :class="hasNumber ? 'text-green-500' : 'text-slate-500'">
                            <i class="fa-solid fa-fw" :class="hasNumber ? 'fa-check' : 'fa-circle text-[0.4rem] align-middle'"></i>
                            At least 1 number
                        </div>
                    </div>

                    <div class="mt-4 flex items-center gap-4">
                        <button type="submit" class="btn btn-main text-xl">Save</button>
                        @if(session('status') === 'password-updated')
                            <span class="text-green-600 text-sm uppercase tracking-widest font-bold">Saved!</span>
                        @endif
                    </div>

                </form>
            </div>
        </section>

        {{-- ===== SECTION 5: MY ACCOUNT (DANGER ZONE) ===== --}}
        <section id="profile-account" class="top-section bg-red-500 text-white flex flex-col"
            x-data="{ confirmOpen: false }">
            <header class="section-header bg-white text-red-500 flex-none">My Account</header>

            <div class="flex-1 flex flex-col justify-center max-w-3xl mx-auto w-full px-4 md:px-8 py-8">
                <div class="text-xl md:text-2xl uppercase font-bold -tracking-[0.04em] mb-1" style="color: rgba(255,255,255,0.7);">
                    Ouhhh, you are sure about that?
                </div>
                <div class="text-xl md:text-2xl uppercase font-bold -tracking-[0.04em] mb-6" style="color: rgba(255,255,255,0.7);">
                    Once deleted, there is no way back, so be careful.
                </div>
                <div>
                    <button @click="confirmOpen = true"
                            class="btn text-[1.5rem] md:text-[2rem] font-bold uppercase -tracking-[0.06em] text-slate-900 hover:text-white transition-all">
                        Delete account
                    </button>
                </div>

                {{-- Confirmation panel — white surface for legible contrast --}}
                <div x-show="confirmOpen" x-transition class="mt-8 bg-white text-slate-700 p-6 rounded shadow-lg" style="display: none;">
                    <form method="POST" action="{{ route('profile.destroy') }}" class="flex flex-col gap-4">
                        @csrf
                        @method('DELETE')
                        <div class="text-lg uppercase font-bold -tracking-[0.04em]">Enter your password to confirm:</div>
                        <div class="text-sm text-slate-500 uppercase">パスワードを入力して確認してください</div>
                        <input type="password" name="password" class="form-input w-full" placeholder="password" required />
                        @error('password', 'userDeletion')
                            <div class="text-red-500 text-sm font-bold mt-1">{{ $message }}</div>
                        @enderror
                        <div class="flex gap-4 mt-2">
                            <button type="submit" class="btn btn-danger text-xl">Confirm deletion</button>
                            <button type="button" @click="confirmOpen = false" class="btn btn-main text-xl">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </main>
</x-layouts.public>
