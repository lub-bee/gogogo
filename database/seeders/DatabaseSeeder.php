<?php

namespace Database\Seeders;

use App\Enums\EventType;
use App\Enums\MediaStatus;
use App\Models\Event;
use App\Models\Location;
use App\Models\Media;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with demo content.
     *
     * No accounts are created. Use `php artisan app:make-admin`
     * to create the first admin user after deployment.
     */
    public function run(): void
    {
        // --- Demo Locations ---
        $locations = Location::factory()->count(5)->create();

        // --- Demo Topics (mix of published, draft, scheduled) ---
        $topics = collect();
        $topics = $topics->merge(Topic::factory()->count(3)->published()->create());
        $topics = $topics->merge(Topic::factory()->count(1)->draft()->create());
        $topics = $topics->merge(Topic::factory()->count(1)->scheduled()->create());

        // --- Demo Events ---
        $events = collect();
        foreach ($topics->where('published_at', '!=', null)->take(3) as $topic) {
            $events = $events->merge(
                Event::factory()
                    ->count(2)
                    ->published()
                    ->create([
                        'topic_id' => $topic->id,
                        'location_id' => $locations->random()->id,
                    ])
            );
        }

        // A draft event
        $events->push(
            Event::factory()->draft()->create([
                'topic_id' => $topics->first()->id,
                'location_id' => $locations->random()->id,
            ])
        );

        // A special event
        $events->push(
            Event::factory()->published()->special()->create([
                'name' => 'GoGoGo Anniversary Party',
                'location_id' => $locations->first()->id,
            ])
        );

        // --- Demo Media (attached to published events) ---
        foreach ($events->take(4) as $event) {
            Media::factory()->count(3)->approved()->create([
                'event_id' => $event->id,
            ]);
        }

        // A pending media
        Media::factory()->pending()->create([
            'event_id' => $events->first()->id,
        ]);
    }
}
