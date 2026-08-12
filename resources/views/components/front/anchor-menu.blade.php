{{--
    Anchor menu — fixed right-side navigation.
    Three modes:
    - Full menu: pass :items for snap-scroll sections (with IntersectionObserver)
    - Back + items: pass both :back and :items — back link as first entry, observer runs
    - Back link only: pass :back alone for sub-pages (no observer)
--}}
@props([
    'items' => [],
    'labels' => [],
    'back' => null,
])

@if(count($items) > 0)
    {{-- Full section menu (optionally with back link) + IntersectionObserver --}}
    <aside id="anchor-menu" class="anchor-menu hidden lg:flex flex-col items-end fixed bottom-4 right-0 p-4 text-right z-50 group/menu text-base">
        @if($back)
            <a href="{{ $back['url'] ?? '#' }}">&#8249; {{ $back['label'] ?? 'Back' }}</a>
        @endif
        @foreach($items as $i => $item)
            <a href="#{{ $item }}">{{ $labels[$i] ?? ucfirst($item) }}</a>
        @endforeach
    </aside>

    <script>
        window.addEventListener('load', function () {
            const sections = document.querySelectorAll('.top-section');
            const menu = document.getElementById('anchor-menu');
            if (!menu || sections.length === 0) return;

            // Sections that get the reversed (white text) menu
            const darkSections = ['agenda', 'media', 'profile-top', 'profile-info'];

            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        menu.querySelectorAll('a[href^="#"]').forEach(function (link) {
                            link.classList.remove('active');
                        });
                        const active = menu.querySelector('a[href="#' + entry.target.id + '"]');
                        if (active) active.classList.add('active');

                        if (darkSections.includes(entry.target.id)) {
                            menu.classList.add('reversed');
                        } else {
                            menu.classList.remove('reversed');
                        }
                    }
                });
            }, { root: null, rootMargin: '0px', threshold: 0.5 });

            sections.forEach(function (section) {
                observer.observe(section);
            });
        });
    </script>
@elseif($back)
    {{-- Back-link only (sub-pages without snap sections) --}}
    <aside class="anchor-menu hidden lg:flex flex-col items-end fixed bottom-4 right-0 p-4 text-right z-50 group/menu text-base">
        <a href="{{ $back['url'] ?? '#' }}">&#8249; {{ $back['label'] ?? 'Back' }}</a>
    </aside>
@endif
