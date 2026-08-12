<?php

namespace Database\Factories;

use App\Enums\EventType;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    private const EVENT_NAMES = [
        'GoGoGo Saturday Meetup',
        'Evening Language Café',
        'Sunday Park Hangout',
        'Shibuya Conversation Night',
        'Ikebukuro Study Session',
        'Shinjuku Welcome Party',
        'Golden Week Special',
        'Year-End Party',
    ];

    public function definition(): array
    {
        $name = fake()->randomElement(self::EVENT_NAMES);
        $startAt = fake()->dateTimeBetween('-3 months', '+3 months');

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numerify('###'),
            'type' => fake()->randomElement(EventType::cases()),
            'start_at' => $startAt,
            'end_at' => (clone $startAt)->modify('+' . fake()->numberBetween(1, 4) . ' hours'),
            'description_en' => fake()->optional(0.8)->paragraph(),
            'description_ja' => fake()->optional(0.8)->randomElement([
                '初心者大歓迎！気軽にご参加ください。',
                '楽しく英語と日本語を練習しましょう！',
                '参加費にはドリンク一杯が含まれています。',
                '少人数制で丁寧にサポートします。',
            ]),
            'published_at' => fake()->optional(0.7)->dateTimeBetween('-6 months', '-1 hour'),
            'cost' => fake()->optional(0.6)->numberBetween(0, 3000),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'published_at' => fake()->dateTimeBetween('-6 months', '-1 hour'),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'published_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn () => [
            'published_at' => fake()->dateTimeBetween('+1 day', '+3 months'),
        ]);
    }

    public function gogogo(): static
    {
        return $this->state(fn () => ['type' => EventType::GoGoGo]);
    }

    public function special(): static
    {
        return $this->state(fn () => ['type' => EventType::Special]);
    }
}
