<x-layouts.management :title="'Events'">
    <x-slot:heading>
        <div class="flex items-center justify-between w-full">
            <h1 class="text-lg font-bold uppercase tracking-widest text-white">
                <i class="fa-solid fa-calendar-days mr-2"></i>Events
            </h1>
            <a href="{{ route('management.events.create') }}"
               class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition">
                <i class="fa-solid fa-plus"></i> New Event
            </a>
        </div>
    </x-slot:heading>

    {{-- Status filter tabs --}}
    <div class="mb-6 flex gap-1 border-b border-slate-200">
        @php
            $tabs = [
                null        => 'All',
                'draft'     => 'Draft',
                'scheduled' => 'Scheduled',
                'published' => 'Published',
            ];
        @endphp
        @foreach ($tabs as $key => $label)
            <a href="{{ route('management.events.index', $key ? ['status' => $key] : []) }}"
               class="px-4 py-2 text-sm font-semibold uppercase tracking-widest border-b-2 transition
                      {{ $status === $key
                          ? 'border-indigo-600 text-indigo-600'
                          : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Events table --}}
    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">Type</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">Location</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-widest text-slate-500">RSVP</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-widest text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($events as $event)
                    <tr class="hover:bg-slate-50 transition">
                        {{-- Name --}}
                        <td class="px-4 py-3 font-bold text-slate-800">
                            <a href="{{ route('management.events.edit', $event) }}" class="hover:text-indigo-600 transition">
                                {{ $event->name }}
                            </a>
                        </td>

                        {{-- Type badge --}}
                        <td class="px-4 py-3">
                            @if ($event->type === \App\Enums\EventType::GoGoGo)
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                                    GoGoGo
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-pink-100 px-2.5 py-0.5 text-xs font-medium text-pink-700">
                                    Special
                                </span>
                            @endif
                        </td>

                        {{-- Date --}}
                        <td class="px-4 py-3 text-slate-600">
                            {{ $event->start_at->format('M j, Y — H:i') }}
                        </td>

                        {{-- Location --}}
                        <td class="px-4 py-3 text-slate-600">
                            {{ $event->location?->name ?? '—' }}
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-3">
                            @if ($event->isDraft())
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">
                                    Draft
                                </span>
                            @elseif ($event->isScheduled())
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-700">
                                    Scheduled
                                </span>
                            @elseif ($event->isPublished())
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">
                                    Published
                                </span>
                            @endif
                        </td>

                        {{-- RSVP count --}}
                        <td class="px-4 py-3 text-center text-slate-600">
                            {{ $event->attendees_count }}
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('management.events.edit', $event) }}"
                                   class="inline-flex items-center gap-1 rounded bg-slate-100 px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-200 transition"
                                   title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                {{-- Publish / Unpublish --}}
                                @if ($event->isDraft() || $event->isScheduled())
                                    <form action="{{ route('management.events.publish', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded bg-green-100 px-2.5 py-1.5 text-xs font-medium text-green-700 hover:bg-green-200 transition"
                                                title="Publish">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('management.events.unpublish', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded bg-yellow-100 px-2.5 py-1.5 text-xs font-medium text-yellow-700 hover:bg-yellow-200 transition"
                                                title="Unpublish">
                                            <i class="fa-solid fa-eye-slash"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- Delete --}}
                                <form action="{{ route('management.events.destroy', $event) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this event?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 rounded bg-red-100 px-2.5 py-1.5 text-xs font-medium text-red-700 hover:bg-red-200 transition"
                                            title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                            <i class="fa-solid fa-calendar-xmark text-3xl mb-2"></i>
                            <p class="text-sm">No events found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $events->links() }}
    </div>
</x-layouts.management>
