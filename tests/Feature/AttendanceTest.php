<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_attend_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->published()->create();

        $event->attendees()->attach($user);

        $this->assertDatabaseHas('attendances', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $this->assertTrue($event->attendees->contains($user));
        $this->assertTrue($user->attendingEvents->contains($event));
    }

    public function test_duplicate_attendance_throws_exception(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->published()->create();

        $event->attendees()->attach($user);

        $this->expectException(QueryException::class);
        $event->attendees()->attach($user);
    }

    public function test_user_can_attend_multiple_events(): void
    {
        $user = User::factory()->create();
        $events = Event::factory()->count(3)->published()->create();

        foreach ($events as $event) {
            $event->attendees()->attach($user);
        }

        $this->assertCount(3, $user->attendingEvents);
    }

    public function test_attendance_cascades_on_user_delete(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->published()->create();

        $event->attendees()->attach($user);
        $this->assertDatabaseCount('attendances', 1);

        $user->delete();
        $this->assertDatabaseCount('attendances', 0);
    }

    public function test_attendance_cascades_on_event_delete(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->published()->create();

        $event->attendees()->attach($user);
        $this->assertDatabaseCount('attendances', 1);

        $event->delete();
        $this->assertDatabaseCount('attendances', 0);
    }
}
