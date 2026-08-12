{{-- Users listing — management area (admin only) --}}

<x-layouts.management title="Users">

    <x-slot:heading>
        <i class="fa-solid fa-users fa-fw mr-2 text-lg"></i>Users
    </x-slot:heading>

    <div class="bg-white rounded shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-left">
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold">Name</th>
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold">Email</th>
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold">Rank</th>
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold">Registered</th>
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold">Media</th>
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 font-bold text-slate-800">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($user->rank === 'admin')
                                <span class="inline-block bg-slate-800 text-white text-xs uppercase tracking-widest font-bold px-2 py-0.5 rounded">Admin</span>
                            @elseif($user->rank === 'support')
                                <span class="inline-block bg-blue-100 text-blue-700 text-xs uppercase tracking-widest font-bold px-2 py-0.5 rounded">Support</span>
                            @else
                                <span class="inline-block bg-slate-200 text-slate-600 text-xs uppercase tracking-widest font-bold px-2 py-0.5 rounded">Member</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-500">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $user->media_count }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('management.users.edit', $user) }}"
                               class="text-xs uppercase tracking-widest font-bold text-slate-500 hover:text-slate-700 transition-colors">
                                <i class="fa-solid fa-pen-to-square fa-fw"></i> Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400 text-sm uppercase tracking-widest">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

</x-layouts.management>
