<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    protected $model = Location::class;

    /** Romanized Sendai-area venue names for realistic seeding. */
    private const VENUES = [
        'The Mall Sendai Nagamachi',
        'Nishikichou Koen',
        'Mediatheque Sendai',
        'Kotodai Koen',
        'Izumi Chuo Station Plaza',
        'Aoba Community Center',
        'Jozenji-dori Avenue',
        'Sendai Station East Exit',
    ];

    public function definition(): array
    {
        $name = fake()->unique()->randomElement(self::VENUES);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numerify('###'),
            'description_en' => fake()->optional(0.7)->sentence(),
            'description_ja' => fake()->optional(0.7)->randomElement([
                '駅から徒歩5分の便利な場所です。',
                'Wi-Fi完備、飲食持ち込み可。',
                '広々とした明るいスペースです。',
                '少人数向けのアットホームな会場。',
            ]),
            'gps_lat' => fake()->optional(0.5)->latitude(38.24, 38.30),
            'gps_lng' => fake()->optional(0.5)->longitude(140.85, 140.92),
            'website_url' => fake()->optional(0.3)->url(),
            'cost' => fake()->optional(0.5)->numberBetween(0, 5000),
        ];
    }
}
