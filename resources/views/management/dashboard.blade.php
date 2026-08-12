<x-layouts.management title="Dashboard">
    <x-slot:heading>
        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
    </x-slot:heading>

    {{-- Stats cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        {{-- Pending Media --}}
        <a href="{{ route('management.media') }}"
           class="block bg-slate-800 border border-slate-700 rounded-lg p-5 hover:border-slate-500 transition-colors">
            <div class="text-[11px] uppercase tracking-widest text-slate-400 mb-1">
                <i class="fas fa-photo-video mr-1"></i> Pending Media
            </div>
            <div class="text-3xl font-bold text-white">{{ $pendingMediaCount }}</div>
        </a>

        {{-- Draft Events --}}
        <a href="{{ route('management.events.index', ['status' => 'draft']) }}"
           class="block bg-slate-800 border border-slate-700 rounded-lg p-5 hover:border-slate-500 transition-colors">
            <div class="text-[11px] uppercase tracking-widest text-slate-400 mb-1">
                <i class="fas fa-calendar-alt mr-1"></i> Draft Events
            </div>
            <div class="text-3xl font-bold text-white">{{ $draftEventsCount }}</div>
        </a>

        {{-- Draft Topics --}}
        <a href="{{ route('management.topics.index') }}"
           class="block bg-slate-800 border border-slate-700 rounded-lg p-5 hover:border-slate-500 transition-colors">
            <div class="text-[11px] uppercase tracking-widest text-slate-400 mb-1">
                <i class="fas fa-comments mr-1"></i> Draft Topics
            </div>
            <div class="text-3xl font-bold text-white">{{ $draftTopicsCount }}</div>
        </a>

        {{-- Total Members (admin only) --}}
        @isset($totalMembers)
        <a href="{{ route('management.users.index') }}"
           class="block bg-slate-800 border border-slate-700 rounded-lg p-5 hover:border-slate-500 transition-colors">
            <div class="text-[11px] uppercase tracking-widest text-slate-400 mb-1">
                <i class="fas fa-users mr-1"></i> Total Members
            </div>
            <div class="text-3xl font-bold text-white">{{ $totalMembers }}</div>
        </a>
        @endisset

    </div>

    {{-- Two-column layout: Upcoming Events + Recent RSVPs --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Upcoming Published Events --}}
        <div class="bg-slate-800 border border-slate-700 rounded-lg">
            <div class="px-5 py-3 border-b border-slate-700">
                <h2 class="text-[11px] uppercase tracking-widest text-slate-400">
                    <i class="fas fa-calendar-check mr-1"></i> Upcoming Events
                </h2>
            </div>
            <ul class="divide-y divide-slate-700">
                @forelse ($upcomingEvents as $event)
                    <li class="px-5 py-3">
                        <div class="text-sm font-medium text-white">{{ $event->name }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">
                            <i class="far fa-clock mr-1"></i>
                            {{ $event->start_at->format('Y-m-d H:i') }}
                            @if($event->location)
                                <span class="ml-3">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $event->location->name }}
                                </span>
                            @endif
                            <span class="ml-3">
                                <i class="fas fa-user mr-1"></i>{{ $event->attendees_count }}
                            </span>
                        </div>
                    </li>
                @empty
                    <li class="px-5 py-6 text-center text-sm text-slate-500">No upcoming events.</li>
                @endforelse
            </ul>
        </div>

        {{-- Recent RSVPs --}}
        <div class="bg-slate-800 border border-slate-700 rounded-lg">
            <div class="px-5 py-3 border-b border-slate-700">
                <h2 class="text-[11px] uppercase tracking-widest text-slate-400">
                    <i class="fas fa-user-check mr-1"></i> Recent RSVPs
                </h2>
            </div>
            <ul class="divide-y divide-slate-700">
                @forelse ($recentRsvps as $rsvp)
                    <li class="px-5 py-3 flex items-center justify-between">
                        <div>
                            <span class="text-sm text-white">{{ $rsvp->user_name }}</span>
                            <span class="text-xs text-slate-500 mx-1">&rarr;</span>
                            <span class="text-xs text-slate-400">{{ $rsvp->event_name }}</span>
                        </div>
                        <div class="text-[11px] text-slate-500 whitespace-nowrap ml-3">
                            {{ \Illuminate\Support\Carbon::parse($rsvp->created_at)->diffForHumans() }}
                        </div>
                    </li>
                @empty
                    <li class="px-5 py-6 text-center text-sm text-slate-500">No recent RSVPs.</li>
                @endforelse
            </ul>
        </div>

    </div>

</x-layouts.management>
