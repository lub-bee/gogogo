<?php

namespace App\Services;

class GreetingService
{
    /** Bilingual casual greetings — name is appended by the caller. */
    private const GREETINGS = [
        '元気？',
        'Howdy,',
        'やっほー',
        "What's up",
        '調子どう？',
        'Hey',
        'おっす！',
        'Yo',
        'ども！',
    ];

    /**
     * Return a random bilingual greeting with the user's name.
     */
    public static function random(string $name): string
    {
        $greeting = self::GREETINGS[array_rand(self::GREETINGS)];

        // Some greetings end with punctuation, some need the name appended
        $needsSpace = ! str_ends_with($greeting, '！') && ! str_ends_with($greeting, '？');

        return $greeting . ($needsSpace ? ' ' : ' ') . $name;
    }
}
