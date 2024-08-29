<div class="w-full flex gap-4">
    <div class='flex-1'>
        <div class="form-input">
            @if($selectedLocation)
                {{ $selectedLocation->name }}
            @else
                No location selected
            @endif
        </div>
        <input type="hidden" name="location_id" value="{{ $selectedLocation ? $selectedLocation->id : '' }}"  />
    </div>



    <div class='flex-1' x-data="{ open: false }">
        @if(!$open)
            <div class='' x-show="!open">
                <button type="button" wire:click="toggleOpen" class="btn btn-success btn-sm btn-outline">Add</button>
                <button type="button" wire:click="clearLocation" class="btn btn-sm btn-outline">Clear</button>
            </div>
        @else
            <div class=''>

                <input
                type="text"
                placeholder="Search location"
                wire:model.live="search"
                class="form-input"
                />

                <div class='mt-2 h-32 overflow-y-scroll border border-slate-400'>
                    <ul class="">
                        @forelse ($locations as $location)
                            <li wire:key="{{ $location->id }}" wire:click="selectLocation({{ $location->id }})" class="p-4 py-1 odd:bg-white even:bg-slate-50 hover:bg-gray-200 transition-colors cursor-pointer" @click="open = false">
                                {{ $location->name }}
                            </li>
                        @empty
                            <li>No locations found</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endif
    </div>

</div>
