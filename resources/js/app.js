import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {

    const slots = [
        {
            id: 'slot1',
            index: 2, // Commence sur le 3e caractère
            sequence: [ // Définit la séquence de rotations
                { direction: 'up', steps: 1 },
                { direction: 'down', steps: 2 },
            ],
            sequenceIndex: 0 // Pour suivre où on en est dans la séquence
        },
        {
            id: 'slot2',
            index: 0,
            sequence: [
                { direction: 'down', steps: 1 },
                { direction: 'up', steps: 2 }
            ],
            sequenceIndex: 0
        },
        {
            id: 'slot3',
            index: 0,
            sequence: [
                { direction: 'up', steps: 1 },
                { direction: 'up', steps: 1 },
                { direction: 'down', steps: 1 }
            ],
            sequenceIndex: 0
        }
    ];

    function updateSlot(slot) {
        const slotElement = document.getElementById(slot.id);
        const lettersElement = slotElement.querySelector('.letters');
        const totalLetters = lettersElement.children.length;

        // Obtenir le mouvement courant dans la séquence
        const currentMove = slot.sequence[slot.sequenceIndex];
        const moveDirection = currentMove.direction;
        const moveSteps = currentMove.steps;

        // Calculer la nouvelle position de l'index selon le mouvement
        if (moveDirection === 'up') {
            slot.index = (slot.index - moveSteps + totalLetters) % totalLetters;
        } else if (moveDirection === 'down') {
            slot.index = (slot.index + moveSteps) % totalLetters;
        }

        // Appliquer la transformation
        const translateY = -slot.index * 10;
        lettersElement.style.transform = `translateY(${translateY}rem)`;

        // Passer à la prochaine étape de la séquence
        slot.sequenceIndex = (slot.sequenceIndex + 1) % slot.sequence.length;
    }

    function animateSlots() {
        slots.forEach(updateSlot);
    }

    // Lancer l'animation
    setInterval(animateSlots, 1500);
});
