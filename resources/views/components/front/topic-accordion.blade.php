{{--
    Topic accordion — one always open, latest by default.
    Usage: <x-front.topic-accordion :topics="$topics" />

    Each topic in $topics: ['name', 'slug', 'description_en', 'description_ja', 'published_at']
--}}
@props([
    'topics' => [
        ['name' => 'I went to a crocodile park and was attacked by a baby one', 'slug' => 'crocodile-park', 'description_en' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora consequuntur, libero cumque inventore saepe ad molestias sunt facilis error est iste.', 'description_ja' => 'これは、いつものように、猫を飼っている猿が、鶏を餌にしていることを知っています。', 'published_at' => '2024-09-22'],
        ['name' => 'The perfect onigiri does not exist and here is why', 'slug' => 'perfect-onigiri', 'description_en' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'description_ja' => '重要なのは、フォースの温度制御です。高すぎると焦げてしまい、低すぎると生焼けになります。', 'published_at' => '2024-09-15'],
        ['name' => "My neighbor's cat is plotting something against me", 'slug' => 'neighbor-cat', 'description_en' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum.', 'description_ja' => 'フォースによる調理中は、ダークサイドに引き寄せられないよう注意してください。', 'published_at' => '2024-09-08'],
        ['name' => 'Best convenience store food ranking of all time', 'slug' => 'conbini-ranking', 'description_en' => 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores.', 'description_ja' => 'この技術は特にヨーダマスターが得意としていたと言われています。', 'published_at' => '2024-08-25'],
    ],
])

<div class="ts2-rows flex-1"
     x-data="{
        ts2En: true, ts2Ja: true, ts2Open: 1,
        ts2ToggleEn() { this.ts2En = !this.ts2En; if (!this.ts2En && !this.ts2Ja) this.ts2Ja = true; },
        ts2ToggleJa() { this.ts2Ja = !this.ts2Ja; if (!this.ts2En && !this.ts2Ja) this.ts2En = true; },
        ts2Toggle(id) { if (id !== this.ts2Open) this.ts2Open = id; }
     }">
    @foreach($topics as $i => $topic)
        @php $idx = $i + 1; @endphp
        <div class="ts2-row" :class="ts2Open === {{ $idx }} && 'ts2-open'" @click="ts2Toggle({{ $idx }})">
            <div class="ts2-title-bar">
                <span class="ts2-row-icon"><i class="fa-solid fa-align-left fa-fw"></i></span>
                <a href="{{ url('/topic/' . ($topic['slug'] ?? '#')) }}"
                   class="ts2-title"
                   @click.stop="if (ts2Open !== {{ $idx }}) { $event.preventDefault(); ts2Toggle({{ $idx }}); }">
                    {{ $topic['name'] }}
                </a>
                <span class="ts2-chevron"><i class="fa-solid fa-chevron-right"></i></span>
            </div>
            <div class="ts2-panel"><div class="ts2-panel-inner">
                <div class="ts2-rail" @click.stop>
                    <span class="ts2-lang" :class="!ts2En && 'ts2-off'" @click="ts2ToggleEn()">
                        <i class="ts2-eye fa-solid" :class="ts2En ? 'fa-eye' : 'fa-eye-slash'"></i> EN
                    </span>
                    <span class="ts2-lang" :class="!ts2Ja && 'ts2-off'" @click="ts2ToggleJa()">
                        <i class="ts2-eye fa-solid" :class="ts2Ja ? 'fa-eye' : 'fa-eye-slash'"></i> 日本語
                    </span>
                    <span class="ts2-date">{{ $topic['published_at'] ?? '' }}</span>
                </div>
                <div class="ts2-excerpt" :class="ts2En && ts2Ja && 'ts2-dual'">
                    <div class="ts2-ex-col" x-show="ts2En">{{ $topic['description_en'] ?? '' }}</div>
                    <div class="ts2-ex-col" x-show="ts2Ja">{{ $topic['description_ja'] ?? '' }}</div>
                </div>
            </div></div>
        </div>
    @endforeach
</div>
