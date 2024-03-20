<x-admin-layout>
    <x-editor-loader/>

    <form method="POST" action={{route("topic.update", $topic->id)}}>
        @csrf
        @method("PUT")

        <div class="section">
            <a href={{ route('topic.show', $topic->id)}} class="btn">Back</a>
        </div>
        <div class="section">
            <div class="block-container p-4">

                <div class="info">
                    <div>Name</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('name')" class="mb-2" />
                        <input type="text" name="name" class="w-full" value="{{$topic->name}}"/>
                    </div>
                </div>

                <div class="info">
                    <div>Memo</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('memo')" class="mb-2" />
                        <input type="text" name="memo" class="w-full" value="{{$topic->memo}}"/>
                        <x-input-info level="warning" class="mt-2">Only visible by admin</x-input-info>
                    </div>
                </div>

                <div class="info">
                    <div>Content (EN)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_en')" class="mb-2" />
                        <textarea name="description_en" class="editor">{{ $topic->description_en}}</textarea>
                    </div>
                </div>

                <div class="info">
                    <div>Content (JA)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_ja')" class="mb-2" />
                        <textarea name="description_ja" class="editor">{{$topic->description_ja}}</textarea>
                    </div>
                </div>

                <div class="info">
                    <div>Status</div>
                    <div class="col-span-3">
                        <div>
                            <label>
                                <input type="radio" name="status" value="draft" {{ old("published_at", $topic->published_at) == null ? 'checked' : '' }}>
                                Draft (Only visible from the administration)
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="radio" name="status" value="published" {{ old("published_at", $topic->published_at) !== null ? 'checked' : '' }}>
                                Published
                                <input type="date" name="published_at" value="{{old("published_at", Carbon\Carbon::now()->format('Y-m-d'))}}" />
                                <x-input-error :messages="$errors->get('published_at')" class="mb-2" />
                            </label>
                        </div>
                    </div>
                </div>

                <div class="info">
                    <div>Author</div>
                    <div class="col-span-3">
                        {{ $topic->user->name }}
                    </div>
                </div>

                <div class="info">
                    <div>Created at</div>
                    <div>
                        {{ $topic->created_at->format('Y-m-d H:i:s') }}
                    </div>
                    <div>Updated at</div>
                    <div>
                        {{ $topic->updated_at->format('Y-m-d H:i:s') }}
                    </div>
                </div>
            </div>

            <div class="flex mt-5 gap-4 justify-center">
                <a href={{ route('topic.show', $topic->id)}} class="btn">
                    Cancel
                </a>
                <button type="submit" class="btn btn-main">
                    Edit
                </button>
            </div>


</x-admin-layout>
