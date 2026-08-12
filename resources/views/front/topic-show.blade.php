{{--
    Topic show — light reader with bilingual columns side-by-side.
    EN/JA tabs with eye toggles, both-visible default at all widths.
    Download control styled sky-200 → yellow-200 hover.
--}}

<x-layouts.public
    :menuBack="['url' => url('/#topic'), 'label' => 'Back']"
    :title="$topic->name . ' — GoGoGo'">

    <div class="flex flex-col h-screen bg-white text-slate-700 font-sans"
         x-data="{
            showEn: true, showJa: true,
            toggleEn() { this.showEn = !this.showEn; if (!this.showEn && !this.showJa) this.showJa = true; },
            toggleJa() { this.showJa = !this.showJa; if (!this.showEn && !this.showJa) this.showEn = true; }
         }">

        {{-- Section header --}}
        <div class="section-header bg-slate-700 text-white flex-none">Topic</div>

        {{-- Title --}}
        <div class="flex-none px-4 md:px-8 lg:px-16 pt-6 pb-4">
            <div class="max-w-6xl mx-auto">
                <div class="tsd-title">{{ $topic->name }}</div>
            </div>
        </div>

        {{-- Scrollable body: rail + columns --}}
        <div class="tsd-body px-4 md:px-8 lg:px-16 pb-8">
            <div class="max-w-6xl mx-auto tsd-content-area">

                {{-- Left rail: language tabs + download --}}
                <div class="tsd-rail">
                    <span class="tsd-lang-tab" :class="!showEn && 'tsd-hidden-lang'" @click="toggleEn()">
                        <i class="tsd-eye fa-solid" :class="showEn ? 'fa-eye' : 'fa-eye-slash'"></i>
                        English
                    </span>
                    <span class="tsd-lang-tab" :class="!showJa && 'tsd-hidden-lang'" @click="toggleJa()">
                        <i class="tsd-eye fa-solid" :class="showJa ? 'fa-eye' : 'fa-eye-slash'"></i>
                        日本語
                    </span>
                    <a href="{{ route('topic.download', $topic) }}" class="tsd-download" title="Download">
                        <i class="fa-solid fa-file-arrow-down fa-fw"></i>
                    </a>
                </div>

                <div class="tsd-columns" :class="showEn && showJa ? 'tsd-dual' : ''">

                    {{-- EN column --}}
                    <div class="tsd-col" x-show="showEn" x-transition.opacity.duration.200ms>
                        @if($topic->description_en)
                            {!! $topic->description_en !!}
                        @else
                            <div class="text-slate-400 italic py-8">No English content available.</div>
                        @endif
                    </div>

                    {{-- Vertical divider (visible in dual mode on md+) --}}
                    <div class="tsd-divider" x-show="showEn && showJa"></div>

                    {{-- JA column --}}
                    <div class="tsd-col" x-show="showJa" x-transition.opacity.duration.200ms>
                        @if($topic->description_ja)
                            {!! $topic->description_ja !!}
                        @else
                            <div class="text-slate-400 italic py-8">日本語のコンテンツはまだありません。</div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
