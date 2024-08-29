<x-admin-layout>

    <div class='section'>
        <h1>Topic Create</h1>
    </div>

    {{-- nav --}}
    <div class='section'>
        <a href="{{route('topic.index')}}" class="btn">Back</a>
    </div>

    {{-- form --}}
    <div class='section'>
        <div class='block-container p-4'>

            <form method="POST" action="{{route('topic.store')}}">
                @csrf

                {{-- title --}}
                <div class="info">
                    <div>Title <x-required/></div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('name')" class="mb-2" />
                        <input type="text" name="name" class="form-input" value='{{old("name")}}'>
                    </div>
                </div>

                {{-- topic slug --}}
                <div class="info">
                    <div>Slug <x-required/></div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('slug')" class="mb-2" />
                        <input type="text" name="slug" class="form-input" value='{{old("slug")}}'>
                    </div>
                </div>

                {{-- memo --}}
                <div class="info">
                    <div>Memo</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('memo')" class="mb-2" />
                        <input type="text" name="memo" class="form-input" value='{{old("memo")}}'>
                        <x-input-info level="warning" class="mt-2">Only visible by admin</x-input-info>
                    </div>
                </div>

                {{-- content (editor) --}}
                <div class="info h-fit">
                    <div>Content (EN)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_en')" class="mb-2" />
                        <textarea id="description_en" name="description_en" class="hidden">{{old('description_en')}}</textarea>
                        <div id="editor_en" class="">{!! old('description_en') !!}</div>
                    </div>
                </div>

                {{-- content (editor) --}}
                <div class="info h-fit">
                    <div>Content (JA)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_ja')" class="mb-2" />
                        <textarea id="description_ja" name="description_ja" class="hidden">{{old('description_ja')}}</textarea>
                        <div id="editor_ja" class="">{!! old('description_ja') !!}</div>
                    </div>
                </div>

                {{-- status --}}
                <div class="info">
                    <div>Status</div>
                    <div class="col-span-3">
                        <div>
                            <label>
                                <input type="radio" name="status" value="draft" {{ old("status", null) == null ? 'checked' : '' }}>
                                Draft (Only visible from the administration)
                            </label>
                        </div>
                        <div>
                            <label>
                                <x-input-error :messages="$errors->get('published_at')" class="mb-2" />
                                <input type="radio" name="status" value="published" {{ old("published_at", null) !== null ? 'checked' : '' }}>
                                Published
                                <div class='inline-block'>
                                    <input type="date" class="form-input" name="published_at" value='{{old("published_at", Carbon\Carbon::now()->format("Y-m-d"))}}'>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-5">
                    <a class="btn" href="{{ route('topic.index') }}">
                        CANCEL
                    </a>
                    <button type="submit" class="btn btn-main">
                        SAVE
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-editor-loader/>
</x-admin-layout>
