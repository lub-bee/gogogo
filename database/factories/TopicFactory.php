<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Topic>
 */
class TopicFactory extends Factory
{
    protected $model = Topic::class;

    private const TOPIC_NAMES = [
        'Weekend Language Exchange',
        'Business English Practice',
        'Japanese Culture Deep Dive',
        'Casual Conversation Hour',
        'JLPT Study Group',
        'Travel Stories Sharing',
        'Movie Discussion Night',
        'Cooking & Vocabulary',
    ];

    public function definition(): array
    {
        $name = fake()->randomElement(self::TOPIC_NAMES);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numerify('###'),
            'memo' => fake()->optional(0.3)->sentence(),
            'description_en' => fake()->optional(0.8)->paragraph(),
            'description_ja' => fake()->optional(0.8)->randomElement([
                '英語と日本語を楽しく練習しましょう！',
                'ビジネス英語のスキルアップを目指す方向けのセッションです。',
                '日本文化について深く学びながら言語交換を行います。',
                'リラックスした雰囲気で自由に会話を楽しみましょう。',
            ]),
            'published_at' => fake()->optional(0.7)->dateTimeBetween('-6 months', '+1 month'),
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
}
