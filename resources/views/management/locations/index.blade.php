{{-- Locations listing — management area --}}

<x-layouts.management title="Locations">

    <x-slot:heading>
        <i class="fa-solid fa-map-marker-alt fa-fw mr-2 text-lg"></i>Locations
    </x-slot:heading>

    <x-slot:headingActions>
        <a href="{{ route('management.locations.create') }}"
           class="inline-flex items-center gap-2 bg-white text-slate-800 px-4 py-2 rounded text-sm uppercase tracking-widest font-bold hover:bg-slate-200 transition-colors">
            <i class="fa-solid fa-plus"></i>New Location
        </a>
    </x-slot:headingActions>

    <div class="bg-white rounded shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-left">
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold">Name</th>
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold">Events</th>
                    <th class="px-4 py-3 text-xs uppercase tracking-widest text-slate-500 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($locations as $location)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3">
                            <a href="{{ route('management.locations.edit', $location) }}" class="font-bold text-slate-800 hover:text-slate-600">
                                {{ $location->name }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $location->events_count }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('management.locations.edit', $location) }}"
                                   class="text-xs uppercase tracking-widest font-bold text-slate-500 hover:text-slate-700 transition-colors">
                                    <i class="fa-solid fa-pen-to-square fa-fw"></i> Edit
                                </a>

                                <form method="POST" action="{{ route('management.locations.destroy', $location) }}" class="inline"
                                      onsubmit="return confirm('{{ $location->events_count > 0 ? 'This location is used by ' . $location->events_count . ' event(s). Deleting it will clear their location field. ' : '' }}Delete location &quot;{{ addslashes($location->name) }}&quot;?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs uppercase tracking-widest font-bold text-red-500 hover:text-red-400 transition-colors">
                                        <i class="fa-solid fa-trash fa-fw"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-slate-400 text-sm uppercase tracking-widest">
                            No locations yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $locations->links() }}
    </div>

</x-layouts.management>
