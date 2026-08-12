{{-- Edit user — management area (admin only) --}}

<x-layouts.management title="Edit User">

    <x-slot:heading>
        <i class="fa-solid fa-users fa-fw mr-2 text-lg"></i>Edit User
    </x-slot:heading>

    @php
        $isSelf = auth()->id() === $user->id;
    @endphp

    <div class="max-w-2xl space-y-6">
        <form method="POST" action="{{ route('management.users.update', $user) }}" class="bg-white rounded shadow-sm p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Name (readonly) --}}
            <div>
                <span class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Name</span>
                <div class="text-sm text-slate-700 bg-slate-50 px-3 py-2 rounded border border-slate-200">
                    {{ $user->name }}
                </div>
            </div>

            {{-- Email (readonly) --}}
            <div>
                <span class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Email</span>
                <div class="text-sm text-slate-700 bg-slate-50 px-3 py-2 rounded border border-slate-200">
                    {{ $user->email }}
                </div>
            </div>

            {{-- Rank --}}
            <div>
                <label for="rank" class="block text-xs uppercase tracking-widest text-slate-500 font-bold mb-1">Rank</label>
                <select name="rank" id="rank"
                        class="w-full rounded border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500"
                        {{ $isSelf ? 'disabled' : '' }}>
                    <option value="admin" {{ old('rank', $user->rank) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="support" {{ old('rank', $user->rank) === 'support' ? 'selected' : '' }}>Support</option>
                    <option value="member" {{ old('rank', $user->rank) === 'member' ? 'selected' : '' }}>Member</option>
                </select>
                @if($isSelf)
                    <p class="mt-1 text-xs text-slate-400 uppercase tracking-widest">You cannot change your own rank.</p>
                @endif
                @error('rank')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-slate-800 text-white px-5 py-2 rounded text-sm uppercase tracking-widest font-bold hover:bg-slate-700 transition-colors"
                        {{ $isSelf ? 'disabled' : '' }}>
                    <i class="fa-solid fa-check"></i>Update User
                </button>
                <a href="{{ route('management.users.index') }}"
                   class="text-sm uppercase tracking-widest font-bold text-slate-500 hover:text-slate-700 transition-colors">
                    Back
                </a>
            </div>
        </form>

        {{-- Delete (hidden if editing self) --}}
        @unless($isSelf)
            <form method="POST" action="{{ route('management.users.destroy', $user) }}"
                  class="bg-white rounded shadow-sm p-6 border border-red-200"
                  onsubmit="return confirm('Delete user &quot;{{ addslashes($user->name) }}&quot;? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-red-600 font-bold">Danger Zone</p>
                        <p class="text-sm text-slate-500 mt-1">Permanently delete this user account.</p>
                    </div>
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded text-sm uppercase tracking-widest font-bold hover:bg-red-500 transition-colors">
                        <i class="fa-solid fa-trash"></i>Delete
                    </button>
                </div>
            </form>
        @endunless
    </div>

</x-layouts.management>
