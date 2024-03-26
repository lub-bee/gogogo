<x-admin-layout>
    <div class='section'>
        <a href="{{route('topic.index')}}" class="btn">Back</a>
    </div>

    <div class='section'>
        <div class='block-container p-4'>

            <form method="POST" action="{{route('topic.store')}}">
                @csrf

                <div class="info">
                    <div>Title</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('name')" class="mb-2" />
                        <input type="text" name="name" class="w-full" value='{{old("name")}}'>
                    </div>
                </div>

                <div class="info">
                    <div>Memo</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('memo')" class="mb-2" />
                        <input type="text" name="memo" class="w-full" value='{{old("memo")}}'>
                        <x-input-info level="warning" class="mt-2">Only visible by admin</x-input-info>
                    </div>
                </div>

                <div class="info h-fit">
                    <div>Content (EN)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_en')" class="mb-2" />
                        <textarea id="description_en" name="description_en" class="hidden">{{old('description_en')}}</textarea>
                        <div id="editor_en" class="">{!! old('description_en') !!}</div>
                    </div>
                </div>


                <div class="info h-fit">
                    <div>Content (JA)</div>
                    <div class="col-span-3">
                        <x-input-error :messages="$errors->get('description_ja')" class="mb-2" />
                        <textarea id="description_ja" name="description_ja" class="hidden">{{old('description_ja')}}</textarea>
                        <div id="editor_ja" class="">{!! old('description_ja') !!}</div>
                    </div>
                </div>

                <div class="info">
                    <div>Status</div>
                    <div class="col-span-3">
                        <div>
                            <label>
                                <input type="radio" name="status" value="draft" {{ old("published_at", null) == null ? 'checked' : '' }}>
                                Draft (Only visible from the administration)
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="radio" name="status" value="published" {{ old("published_at", null) !== null ? 'checked' : '' }}>
                                Published
                                <input type="date" name="published_at" value='{{old("published_at", Carbon\Carbon::now()->format("Y-m-d"))}}'>
                                <x-input-error :messages="$errors->get('published_at')" class="mb-2" />
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
