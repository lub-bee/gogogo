<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Location;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlugBindingTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_slug_auto_generated(): void
    {
        $event = Event::factory()->create(['name' => 'Summer Festival 2026', 'slug' => null]);

        $this->assertEquals('summer-festival-2026', $event->slug);
    }

    public function test_topic_slug_auto_generated(): void
    {
        $topic = Topic::factory()->create(['name' => 'Business English', 'slug' => null]);

        $this->assertEquals('business-english', $topic->slug);
    }

    public function test_location_slug_auto_generated(): void
    {
        $location = Location::factory()->create(['name' => 'Shibuya Café', 'slug' => null]);

        $this->assertEquals('shibuya-cafe', $location->slug);
    }

    public function test_explicit_slug_is_not_overwritten(): void
    {
        $event = Event::factory()->create([
            'name' => 'Some Event',
            'slug' => 'my-custom-slug',
        ]);

        $this->assertEquals('my-custom-slug', $event->slug);
    }

    public function test_route_key_name_is_slug(): void
    {
        $event = new Event;
        $topic = new Topic;
        $location = new Location;

        $this->assertEquals('slug', $event->getRouteKeyName());
        $this->assertEquals('slug', $topic->getRouteKeyName());
        $this->assertEquals('slug', $location->getRouteKeyName());
    }

    public function test_resolve_route_binding_by_slug(): void
    {
        $event = Event::factory()->create(['slug' => 'test-binding']);

        $resolved = (new Event)->resolveRouteBinding('test-binding');

        $this->assertNotNull($resolved);
        $this->assertEquals($event->id, $resolved->id);
    }
}
