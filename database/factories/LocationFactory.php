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

    /** Sample JP venue names for realistic seeding. */
    private const JP_VENUES = [
        '渋谷コミュニティセンター',
        '新宿カフェスペース',
        '池袋国際交流ラウンジ',
        '六本木ヒルズ会議室',
        '下北沢カルチャーハウス',
        '中目黒カフェ',
        '代官山ワークスペース',
        '表参道コワーキング',
    ];

    public function definition(): array
    {
        $name = fake()->randomElement(self::JP_VENUES) . ' ' . fake()->numberBetween(1, 99);

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
            'gps_lat' => fake()->optional(0.5)->latitude(35.6, 35.8),
            'gps_lng' => fake()->optional(0.5)->longitude(139.6, 139.8),
            'website_url' => fake()->optional(0.3)->url(),
            'cost' => fake()->optional(0.5)->numberBetween(0, 5000),
        ];
    }
}
