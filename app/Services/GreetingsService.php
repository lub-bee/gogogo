<?php

namespace App\Services;

class GreetingsService
{
    const HELLOS = [
        // english
        "Hey,",
        "Hello,",
        "Hi,",
        "Greetings,",
        "Hello there,",
        "Howdy,",
        "What's up,",
        "Hi there,",

        // japanese
        "やあ、",
        "よっ、",
        "こんにちは、",
        "おっす!",
        "元気？",
        "おはよう、",
        "おはようございます、",
        "オザース、",
        "こんばんは",
    ];

    public function hello()
    {
        return self::HELLOS[array_rand(self::HELLOS)];
    }
}
