<x-admin-layout>


        <div class="section">
            <a href="{{ route('topic.show', $topic->id)}}" class="btn">Back</a>
        </div>
        <div class="section">
            <div class="block-container p-4">
                <form method="POST" action="{{route('topic.update', $topic->id)}}">
                    @csrf
                    @method("PUT")

                    <div class="info">
                        <div>Name (Required) </div>
                        <div class="col-span-3">
                            <x-input-error :messages="$errors->get('name')" class="mb-2" />
                            <input type="text" name="name" class="w-full" value='{{old("name", $topic->name)}}'>
                        </div>
                    </div>

                    <div class="info">
                        <div>Memo</div>
                        <div class="col-span-3">
                            <x-input-error :messages="$errors->get('memo')" class="mb-2" />
                            <input type="text" name="memo" class="w-full" value='{{old("memo", $topic->memo)}}'>
                            <x-input-info level="warning" class="mt-2">Only visible by admin</x-input-info>
                        </div>
                    </div>

                    <div class="info">
                        <div>Content (EN)</div>
                        <div class="col-span-3">
                            <x-input-error :messages="$errors->get('description_en')" class="mb-2" />
                            <textarea id="description_en" name="description_en" class="hidden"></textarea>
                            <div id="editor_en" class="">{!! old('description_en', $topic->description_en) !!}</div>
                        </div>
                    </div>

                    <div class="info">
                        <div>Content (JA)</div>
                        <div class="col-span-3">
                            <x-input-error :messages="$errors->get('description_ja')" class="mb-2" />
                            <textarea id="description_ja" name="description_ja" class="hidden"></textarea>
                            <div id="editor_ja" class="">{!! old('description_ja', $topic->description_ja) !!}</div>
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
                                    <input type="date" name="published_at" value='{{old("published_at", Carbon\Carbon::now()->format("Y-m-d"))}}' />
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

                    <div class="flex mt-5 gap-4 justify-center">
                        <a href="{{ route('topic.show', $topic->id)}}" class="btn">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-main">
                            Edit
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <div class='section'>
            <div class='block-container p-4 '>
                <form method="POST" action="{{ route('topic.destroy') }}" >
                    @csrf
                    @method("delete")

                    <input type="hidden" name="topic_id" value="{{$topic->id}}" />
                    <div class="text-xl">
                        Delete the topic
                    </div>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>

    <x-editor-loader/>

</x-admin-layout>
