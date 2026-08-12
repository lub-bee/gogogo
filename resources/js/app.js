import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/* ── Slot-machine logo animation ──
   Three slots cycle through 五語Go characters every 1.5s.
   Each slot has a sequence of {direction, steps} that repeats. */
document.addEventListener('DOMContentLoaded', function () {
    const slots = [
        {
            id: 'slot1',
            index: 2,
            sequence: [
                { direction: 'up', steps: 1 },
                { direction: 'down', steps: 2 },
            ],
            sequenceIndex: 0,
        },
        {
            id: 'slot2',
            index: 0,
            sequence: [
                { direction: 'down', steps: 1 },
                { direction: 'up', steps: 2 },
            ],
            sequenceIndex: 0,
        },
        {
            id: 'slot3',
            index: 0,
            sequence: [
                { direction: 'up', steps: 1 },
                { direction: 'up', steps: 1 },
                { direction: 'down', steps: 1 },
            ],
            sequenceIndex: 0,
        },
    ];

    function tick(slot) {
        const el = document.getElementById(slot.id);
        if (!el) return;

        const letters = el.querySelector('.letters');
        const count = letters.children.length;
        const move = slot.sequence[slot.sequenceIndex];

        if (move.direction === 'up') {
            slot.index = (slot.index - move.steps + count) % count;
        } else {
            slot.index = (slot.index + move.steps) % count;
        }

        const offset = -slot.index * 10;
        letters.style.transform = `translateY(${offset}rem)`;
        slot.sequenceIndex = (slot.sequenceIndex + 1) % slot.sequence.length;
    }

    function animate() {
        slots.forEach(tick);
    }

    setInterval(animate, 1500);
});
