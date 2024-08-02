<div class="w-full flex gap-4">
    <div class='flex-1'>
        <div class="form-input">
            @if($selectedTopic)
                {{ $selectedTopic->name }}
            @else
                No topic selected
            @endif
        </div>
        <input type="hidden" name="topic_id" value="{{ $selectedTopic ? $selectedTopic->id : '' }}"  />
    </div>



    <div class='flex-1' x-data="{ open: false }">
        @if(!$open)
            <div class='' x-show="!open">
                <button type="button" wire:click="toggleOpen" class="btn btn-success btn-sm btn-outline">Add</button>
                <button type="button" wire:click="clearTopic" class="btn btn-sm btn-outline">Clear</button>
            </div>
        @else
            <div class=''>

                <input
                    type="text"
                    placeholder="Search topic"
                    wire:model.live="search"
                    class="form-input"
                />

                <div class='mt-2 h-32 overflow-y-scroll border border-slate-400'>
                    <ul class="">
                        @forelse ($topics as $topic)
                            <li wire:key="{{ $topic->id }}" wire:click="selectTopic({{ $topic->id }})" class="p-4 py-1 odd:bg-white even:bg-slate-50 hover:bg-gray-200 transition-colors cursor-pointer" @click="open = false">
                                {{ $topic->name }}
                            </li>
                        @empty
                            <li>No topics found</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endif
    </div>

</div>
