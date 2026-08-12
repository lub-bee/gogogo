<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PublishableTest extends TestCase
{
    use RefreshDatabase;

    // --- Topic (representative Publishable model) ---

    public function test_draft_topic_is_draft(): void
    {
        $topic = Topic::factory()->draft()->create();

        $this->assertTrue($topic->isDraft());
        $this->assertFalse($topic->isPublished());
        $this->assertFalse($topic->isScheduled());
    }

    public function test_published_topic_is_published(): void
    {
        $topic = Topic::factory()->create([
            'published_at' => Carbon::now()->subHour(),
        ]);

        $this->assertTrue($topic->isPublished());
        $this->assertFalse($topic->isDraft());
        $this->assertFalse($topic->isScheduled());
    }

    public function test_scheduled_topic_is_scheduled(): void
    {
        $topic = Topic::factory()->create([
            'published_at' => Carbon::now()->addDay(),
        ]);

        $this->assertTrue($topic->isScheduled());
        $this->assertFalse($topic->isDraft());
        $this->assertFalse($topic->isPublished());
    }

    public function test_publish_sets_published_at_to_now(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-06-15 12:00:00'));

        $topic = Topic::factory()->draft()->create();
        $this->assertTrue($topic->isDraft());

        $topic->publish();
        $topic->refresh();

        $this->assertTrue($topic->isPublished());
        $this->assertEquals('2026-06-15 12:00:00', $topic->published_at->toDateTimeString());

        Carbon::setTestNow();
    }

    public function test_scope_published_returns_only_published(): void
    {
        Topic::factory()->published()->count(2)->create();
        Topic::factory()->draft()->count(1)->create();
        Topic::factory()->scheduled()->count(1)->create();

        $published = Topic::published()->get();

        $this->assertCount(2, $published);
    }

    // --- Event uses same trait, verify it works there too ---

    public function test_event_publishable_trait(): void
    {
        $draft = Event::factory()->draft()->create();
        $published = Event::factory()->published()->create();

        $this->assertTrue($draft->isDraft());
        $this->assertTrue($published->isPublished());

        $this->assertCount(1, Event::published()->get());
    }
}
