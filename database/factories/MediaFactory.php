<?php

namespace Database\Factories;

use App\Enums\MediaStatus;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    protected $model = Media::class;

    public function definition(): array
    {
        return [
            'path' => 'uploads/' . fake()->uuid() . '.jpg',
            'thumbnail_path' => fake()->optional(0.8)->passthrough('thumbnails/' . fake()->uuid() . '.jpg'),
            'legend' => fake()->optional(0.5)->randomElement([
                'Group photo at the event',
                'イベントの集合写真',
                'Language exchange in action',
                '言語交換の様子',
            ]),
            'status' => fake()->randomElement(MediaStatus::cases()),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn () => ['status' => MediaStatus::Pending]);
    }

    public function approved(): static
    {
        return $this->state(fn () => ['status' => MediaStatus::Approved]);
    }

    public function refused(): static
    {
        return $this->state(fn () => ['status' => MediaStatus::Refused]);
    }
}
