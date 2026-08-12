{{--
    Topic show — light reader with bilingual columns side-by-side.
    EN/JA tabs with eye toggles, both-visible default at all widths.
    Download control styled sky-200 → yellow-200 hover.
--}}
@props([
    'topic' => [
        'name' => 'How to grill sardines only using the power of the Force.',
        'slug' => 'grill-sardines',
        'description_en' => null,
        'description_ja' => null,
        'published_at' => '2024-09-22',
    ],
])

<x-layouts.public
    :menuBack="['url' => url('/#topic'), 'label' => 'Back']"
    :title="($topic['name'] ?? 'Topic') . ' — GoGoGo'">

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
                <div class="tsd-title">{{ $topic['name'] }}</div>
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
                    <a href="{{ url('/topic/' . ($topic['slug'] ?? '#') . '/download') }}" class="tsd-download" title="Download">
                        <i class="fa-solid fa-file-arrow-down fa-fw"></i>
                    </a>
                </div>

                <div class="tsd-columns" :class="showEn && showJa ? 'tsd-dual' : ''">

                    {{-- EN column --}}
                    <div class="tsd-col" x-show="showEn" x-transition.opacity.duration.200ms>
                        @if($topic['description_en'] ?? null)
                            {!! $topic['description_en'] !!}
                        @else
                            {{-- Placeholder content --}}
                            <div class="t1">Title 1</div>
                            <div class="sub">Subtitle</div>
                            <div class="subsub">Subsubtitle</div>
                            <div class="normal">Normal text — this is placeholder content. The real topic content will be rendered here from the database, using the canonical formatting from Google Docs.</div>
                            <ol>
                                <li>First item in the numbered list</li>
                                <li>Second item in the numbered list</li>
                                <li>Third item in the numbered list</li>
                            </ol>
                            <div class="rich-line">
                                <a href="#">Some link here</a>, some <strong>bold text</strong>, some <u>underlined</u> and some <em>italic</em> there.
                            </div>
                            <div class="sub">Vocabulary list</div>
                            <table>
                                <thead><tr><th>English</th><th>日本語</th></tr></thead>
                                <tbody>
                                    <tr><td>Sardine</td><td>イワシ</td></tr>
                                    <tr><td>Grill</td><td>焼く</td></tr>
                                    <tr><td>Force</td><td>フォース</td></tr>
                                    <tr><td>Levitation</td><td>浮遊</td></tr>
                                    <tr><td>Seasoning</td><td>調味料</td></tr>
                                    <tr><td>Crispy</td><td>カリカリ</td></tr>
                                </tbody>
                            </table>
                            <div class="t1">Additional section</div>
                            <div class="sub">More details below</div>
                            <div class="normal">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                        @endif
                    </div>

                    {{-- Vertical divider (visible in dual mode on md+) --}}
                    <div class="tsd-divider" x-show="showEn && showJa"></div>

                    {{-- JA column --}}
                    <div class="tsd-col" x-show="showJa" x-transition.opacity.duration.200ms>
                        @if($topic['description_ja'] ?? null)
                            {!! $topic['description_ja'] !!}
                        @else
                            {{-- Placeholder content --}}
                            <div class="t1">タイトル 1</div>
                            <div class="sub">サブタイトル</div>
                            <div class="subsub">サブサブタイトル</div>
                            <div class="normal">通常のテキスト — これはプレースホルダーコンテンツです。実際のトピックコンテンツはデータベースからここに表示されます。</div>
                            <ol>
                                <li>番号付きリストの最初の項目</li>
                                <li>番号付きリストの2番目の項目</li>
                                <li>番号付きリストの3番目の項目</li>
                            </ol>
                            <div class="rich-line">
                                <a href="#">リンクはこちら</a>、<strong>太字テキスト</strong>、<u>下線付き</u>、そして<em>イタリック</em>もあります。
                            </div>
                            <div class="sub">語彙リスト</div>
                            <table>
                                <thead><tr><th>English</th><th>日本語</th></tr></thead>
                                <tbody>
                                    <tr><td>Sardine</td><td>イワシ</td></tr>
                                    <tr><td>Grill</td><td>焼く</td></tr>
                                    <tr><td>Force</td><td>フォース</td></tr>
                                    <tr><td>Levitation</td><td>浮遊</td></tr>
                                    <tr><td>Seasoning</td><td>調味料</td></tr>
                                    <tr><td>Crispy</td><td>カリカリ</td></tr>
                                </tbody>
                            </table>
                            <div class="t1">追加セクション</div>
                            <div class="sub">詳細情報</div>
                            <div class="normal">フォースの力だけでイワシを焼く方法は、古くからジェダイの間で伝えられてきた秘伝の技術です。</div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
