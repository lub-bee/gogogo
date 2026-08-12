<?php

namespace Tests\Feature;

use App\Enums\EventType;
use App\Enums\MediaStatus;
use App\Models\Event;
use App\Models\Location;
use App\Models\Media;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagementTest extends TestCase
{
    use RefreshDatabase;

    // ────────────────────────────────────────────
    // Helpers
    // ────────────────────────────────────────────

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    private function support(): User
    {
        return User::factory()->support()->create();
    }

    private function member(): User
    {
        return User::factory()->member()->create();
    }

    // ────────────────────────────────────────────
    // Access matrix: rank-based access control
    // ────────────────────────────────────────────

    public function test_member_gets_403_on_all_management_routes(): void
    {
        $member = $this->member();
        $event = Event::factory()->for($member)->create();
        $topic = Topic::factory()->for($member)->create();
        $location = Location::factory()->for($member)->create();

        $routes = [
            ['GET', '/management'],
            ['GET', '/management/events'],
            ['GET', '/management/events/create'],
            ['POST', '/management/events'],
            ['GET', "/management/events/{$event->id}/edit"],
            ['PUT', "/management/events/{$event->id}"],
            ['DELETE', "/management/events/{$event->id}"],
            ['GET', '/management/topics'],
            ['GET', '/management/topics/create'],
            ['POST', '/management/topics'],
            ['GET', "/management/topics/{$topic->id}/edit"],
            ['PUT', "/management/topics/{$topic->id}"],
            ['DELETE', "/management/topics/{$topic->id}"],
            ['GET', '/management/locations'],
            ['GET', '/management/locations/create'],
            ['POST', '/management/locations'],
            ['GET', "/management/locations/{$location->id}/edit"],
            ['PUT', "/management/locations/{$location->id}"],
            ['DELETE', "/management/locations/{$location->id}"],
            ['GET', '/management/media'],
            ['GET', '/management/users'],
        ];

        foreach ($routes as [$method, $uri]) {
            $response = $this->actingAs($member)->call($method, $uri);
            $this->assertTrue(
                $response->status() === 403,
                "Expected 403 for {$method} {$uri}, got {$response->status()}"
            );
        }
    }

    public function test_support_can_access_content_management_routes(): void
    {
        $support = $this->support();

        $this->actingAs($support)->get('/management')->assertOk();
        $this->actingAs($support)->get('/management/events')->assertOk();
        $this->actingAs($support)->get('/management/events/create')->assertOk();
        $this->actingAs($support)->get('/management/topics')->assertOk();
        $this->actingAs($support)->get('/management/topics/create')->assertOk();
        $this->actingAs($support)->get('/management/locations')->assertOk();
        $this->actingAs($support)->get('/management/locations/create')->assertOk();
        $this->actingAs($support)->get('/management/media')->assertOk();
    }

    public function test_support_cannot_access_user_management(): void
    {
        $support = $this->support();

        $this->actingAs($support)->get('/management/users')->assertForbidden();
    }

    public function test_admin_can_access_user_management(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/management/users')->assertOk();
    }

    public function test_admin_can_access_all_management_routes(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/management')->assertOk();
        $this->actingAs($admin)->get('/management/events')->assertOk();
        $this->actingAs($admin)->get('/management/events/create')->assertOk();
        $this->actingAs($admin)->get('/management/topics')->assertOk();
        $this->actingAs($admin)->get('/management/locations')->assertOk();
        $this->actingAs($admin)->get('/management/media')->assertOk();
        $this->actingAs($admin)->get('/management/users')->assertOk();
    }

    public function test_sidebar_contains_back_to_site_link(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/management')
            ->assertOk()
            ->assertSee('Back to site')
            ->assertSee(route('top'));
    }

    // ────────────────────────────────────────────
    // Dashboard
    // ────────────────────────────────────────────

    public function test_dashboard_shows_pending_media_count(): void
    {
        $admin = $this->admin();
        Media::factory()->pending()->for($admin)->count(3)->create();

        $this->actingAs($admin)->get('/management')
            ->assertOk()
            ->assertSee('3');
    }

    public function test_dashboard_shows_upcoming_events_with_rsvp_count(): void
    {
        $admin = $this->admin();
        $event = Event::factory()->published()->for($admin)->create([
            'name' => 'Future Event',
            'start_at' => now()->addDays(5),
            'end_at' => now()->addDays(5)->addHours(2),
        ]);

        // Add 3 RSVPs
        $members = User::factory()->member()->count(3)->create();
        foreach ($members as $member) {
            $event->attendees()->attach($member);
        }

        $response = $this->actingAs($admin)->get('/management');
        $response->assertOk()
            ->assertSee('Future Event')
            ->assertSee('3'); // RSVP count visible
    }

    public function test_dashboard_shows_total_members_for_admin_only(): void
    {
        $admin = $this->admin();
        $support = $this->support();
        User::factory()->member()->count(3)->create();

        // Admin sees total count
        $response = $this->actingAs($admin)->get('/management');
        $response->assertOk()->assertSee('Members');

        // Support does NOT see total count
        $response = $this->actingAs($support)->get('/management');
        $response->assertOk()->assertDontSee('Total Members');
    }

    // ────────────────────────────────────────────
    // Event CRUD
    // ────────────────────────────────────────────

    public function test_event_index_lists_events(): void
    {
        $admin = $this->admin();
        Event::factory()->for($admin)->create(['name' => 'Test Event']);

        $this->actingAs($admin)->get('/management/events')
            ->assertOk()
            ->assertSee('Test Event');
    }

    public function test_event_index_filters_by_status(): void
    {
        $admin = $this->admin();
        Event::factory()->draft()->for($admin)->create(['name' => 'Draft Event']);
        Event::factory()->published()->for($admin)->create(['name' => 'Published Event']);

        $this->actingAs($admin)->get('/management/events?status=draft')
            ->assertSee('Draft Event')
            ->assertDontSee('Published Event');

        $this->actingAs($admin)->get('/management/events?status=published')
            ->assertSee('Published Event')
            ->assertDontSee('Draft Event');
    }

    public function test_create_event_happy_path(): void
    {
        $admin = $this->admin();
        $location = Location::factory()->for($admin)->create();

        $this->actingAs($admin)->post('/management/events', [
            'name' => 'New Meetup',
            'type' => EventType::GoGoGo->value,
            'start_at' => '2026-09-01 18:00',
            'end_at' => '2026-09-01 20:00',
            'description_en' => 'English description',
            'description_ja' => 'Japanese description',
            'cost' => 500,
            'location_id' => $location->id,
        ])->assertRedirect('/management/events');

        $this->assertDatabaseHas('events', [
            'name' => 'New Meetup',
            'slug' => 'new-meetup',
            'type' => 'gogogo',
            'cost' => 500,
            'location_id' => $location->id,
            'user_id' => $admin->id,
        ]);
    }

    public function test_create_event_validation_requires_name(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/management/events', [
            'type' => EventType::GoGoGo->value,
            'start_at' => '2026-09-01 18:00',
            'end_at' => '2026-09-01 20:00',
        ])->assertSessionHasErrors('name');
    }

    public function test_create_event_validation_end_after_start(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/management/events', [
            'name' => 'Bad Event',
            'type' => EventType::GoGoGo->value,
            'start_at' => '2026-09-01 20:00',
            'end_at' => '2026-09-01 18:00',
        ])->assertSessionHasErrors('end_at');
    }

    public function test_update_event_happy_path(): void
    {
        $admin = $this->admin();
        $event = Event::factory()->for($admin)->create(['name' => 'Old Name']);

        $this->actingAs($admin)->put("/management/events/{$event->id}", [
            'name' => 'New Name',
            'slug' => $event->slug,
            'type' => EventType::Special->value,
            'start_at' => '2026-09-01 18:00',
            'end_at' => '2026-09-01 20:00',
        ])->assertRedirect('/management/events');

        $event->refresh();
        $this->assertEquals('New Name', $event->name);
        $this->assertEquals(EventType::Special, $event->type);
    }

    public function test_update_event_unique_slug_ignores_self(): void
    {
        $admin = $this->admin();
        $event = Event::factory()->for($admin)->create(['slug' => 'my-event']);

        // Updating with same slug should succeed
        $this->actingAs($admin)->put("/management/events/{$event->id}", [
            'name' => 'Updated Name',
            'slug' => 'my-event',
            'type' => EventType::GoGoGo->value,
            'start_at' => '2026-09-01 18:00',
            'end_at' => '2026-09-01 20:00',
        ])->assertRedirect('/management/events');
    }

    public function test_update_event_unique_slug_fails_on_collision(): void
    {
        $admin = $this->admin();
        Event::factory()->for($admin)->create(['slug' => 'taken-slug']);
        $event = Event::factory()->for($admin)->create(['slug' => 'my-slug']);

        $this->actingAs($admin)->put("/management/events/{$event->id}", [
            'name' => 'Test',
            'slug' => 'taken-slug',
            'type' => EventType::GoGoGo->value,
            'start_at' => '2026-09-01 18:00',
            'end_at' => '2026-09-01 20:00',
        ])->assertSessionHasErrors('slug');
    }

    public function test_publish_event(): void
    {
        $admin = $this->admin();
        $event = Event::factory()->draft()->for($admin)->create();

        $this->assertNull($event->published_at);

        $this->actingAs($admin)->post("/management/events/{$event->id}/publish")
            ->assertRedirect();

        $event->refresh();
        $this->assertNotNull($event->published_at);
        $this->assertTrue($event->isPublished());
    }

    public function test_unpublish_event(): void
    {
        $admin = $this->admin();
        $event = Event::factory()->published()->for($admin)->create();

        $this->actingAs($admin)->post("/management/events/{$event->id}/unpublish")
            ->assertRedirect();

        $event->refresh();
        $this->assertNull($event->published_at);
        $this->assertTrue($event->isDraft());
    }

    public function test_delete_event(): void
    {
        $admin = $this->admin();
        $event = Event::factory()->for($admin)->create();

        $this->actingAs($admin)->delete("/management/events/{$event->id}")
            ->assertRedirect('/management/events');

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    // ────────────────────────────────────────────
    // Topic CRUD
    // ────────────────────────────────────────────

    public function test_topic_index_lists_topics(): void
    {
        $admin = $this->admin();
        Topic::factory()->for($admin)->create(['name' => 'Test Topic']);

        $this->actingAs($admin)->get('/management/topics')
            ->assertOk()
            ->assertSee('Test Topic');
    }

    public function test_create_topic_happy_path(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/management/topics', [
            'name' => 'New Topic',
            'memo' => 'Some memo',
            'description_en' => 'EN desc',
        ])->assertRedirect('/management/topics');

        $this->assertDatabaseHas('topics', [
            'name' => 'New Topic',
            'slug' => 'new-topic',
            'user_id' => $admin->id,
        ]);
    }

    public function test_update_topic_unique_slug_ignores_self(): void
    {
        $admin = $this->admin();
        $topic = Topic::factory()->for($admin)->create(['slug' => 'my-topic']);

        $this->actingAs($admin)->put("/management/topics/{$topic->id}", [
            'name' => 'Updated',
            'slug' => 'my-topic',
        ])->assertRedirect('/management/topics');
    }

    public function test_update_topic_unique_slug_fails_on_collision(): void
    {
        $admin = $this->admin();
        Topic::factory()->for($admin)->create(['slug' => 'taken']);
        $topic = Topic::factory()->for($admin)->create(['slug' => 'mine']);

        $this->actingAs($admin)->put("/management/topics/{$topic->id}", [
            'name' => 'Test',
            'slug' => 'taken',
        ])->assertSessionHasErrors('slug');
    }

    public function test_publish_topic(): void
    {
        $admin = $this->admin();
        $topic = Topic::factory()->draft()->for($admin)->create();

        $this->actingAs($admin)->post("/management/topics/{$topic->id}/publish")
            ->assertRedirect();

        $topic->refresh();
        $this->assertTrue($topic->isPublished());
    }

    public function test_delete_topic(): void
    {
        $admin = $this->admin();
        $topic = Topic::factory()->for($admin)->create();

        $this->actingAs($admin)->delete("/management/topics/{$topic->id}")
            ->assertRedirect('/management/topics');

        $this->assertDatabaseMissing('topics', ['id' => $topic->id]);
    }

    // ────────────────────────────────────────────
    // Location CRUD
    // ────────────────────────────────────────────

    public function test_location_index_lists_locations(): void
    {
        $admin = $this->admin();
        Location::factory()->for($admin)->create(['name' => 'Test Place']);

        $this->actingAs($admin)->get('/management/locations')
            ->assertOk()
            ->assertSee('Test Place');
    }

    public function test_create_location_happy_path(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/management/locations', [
            'name' => 'New Place',
            'gps_lat' => 38.2682,
            'gps_lng' => 140.8694,
        ])->assertRedirect('/management/locations');

        $this->assertDatabaseHas('locations', [
            'name' => 'New Place',
            'slug' => 'new-place',
        ]);
    }

    public function test_update_location_unique_slug_ignores_self(): void
    {
        $admin = $this->admin();
        $location = Location::factory()->for($admin)->create(['slug' => 'my-place']);

        $this->actingAs($admin)->put("/management/locations/{$location->id}", [
            'name' => 'Updated',
            'slug' => 'my-place',
        ])->assertRedirect('/management/locations');
    }

    public function test_delete_location_warns_about_events(): void
    {
        $admin = $this->admin();
        $location = Location::factory()->for($admin)->create();
        Event::factory()->for($admin)->create(['location_id' => $location->id]);

        $this->actingAs($admin)->delete("/management/locations/{$location->id}")
            ->assertRedirect('/management/locations')
            ->assertSessionHas('status');

        // Location deleted, event's location_id set to null
        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }

    // ────────────────────────────────────────────
    // User management
    // ────────────────────────────────────────────

    public function test_user_index_lists_users(): void
    {
        $admin = $this->admin();
        User::factory()->member()->create(['name' => 'John Doe']);

        $this->actingAs($admin)->get('/management/users')
            ->assertOk()
            ->assertSee('John Doe');
    }

    public function test_update_user_rank(): void
    {
        $admin = $this->admin();
        $user = User::factory()->member()->create();

        $this->actingAs($admin)->put("/management/users/{$user->id}", [
            'rank' => User::RANK_SUPPORT,
        ])->assertRedirect('/management/users');

        $user->refresh();
        $this->assertEquals(User::RANK_SUPPORT, $user->rank);
    }

    public function test_admin_cannot_demote_self(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->put("/management/users/{$admin->id}", [
            'rank' => User::RANK_MEMBER,
        ])->assertRedirect()->assertSessionHas('error');

        $admin->refresh();
        $this->assertEquals(User::RANK_ADMIN, $admin->rank);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->delete("/management/users/{$admin->id}")
            ->assertForbidden();

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_delete_other_user(): void
    {
        $admin = $this->admin();
        $user = User::factory()->member()->create();

        $this->actingAs($admin)->delete("/management/users/{$user->id}")
            ->assertRedirect('/management/users');

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    // ────────────────────────────────────────────
    // Media management (extended)
    // ────────────────────────────────────────────

    public function test_media_index_shows_tabs(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/management/media')
            ->assertOk()
            ->assertSee('Pending')
            ->assertSee('Approved')
            ->assertSee('Refused');
    }

    public function test_media_tab_filtering(): void
    {
        $admin = $this->admin();
        Media::factory()->approved()->for($admin)->count(2)->create();
        Media::factory()->pending()->for($admin)->count(1)->create();

        $this->actingAs($admin)->get('/management/media?tab=approved')
            ->assertOk();
    }

    public function test_re_refuse_approved_media(): void
    {
        $admin = $this->admin();
        $media = Media::factory()->approved()->for($admin)->create();

        $this->actingAs($admin)->post("/management/media/{$media->id}/re-refuse")
            ->assertRedirect();

        $media->refresh();
        $this->assertEquals(MediaStatus::Refused, $media->status);
    }

    public function test_re_refuse_only_works_on_approved(): void
    {
        $admin = $this->admin();
        $media = Media::factory()->pending()->for($admin)->create();

        $this->actingAs($admin)->post("/management/media/{$media->id}/re-refuse")
            ->assertRedirect()
            ->assertSessionHas('error');
    }

    public function test_delete_media(): void
    {
        $admin = $this->admin();
        $media = Media::factory()->refused()->for($admin)->create();

        $this->actingAs($admin)->delete("/management/media/{$media->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('media', ['id' => $media->id]);
    }

    // ────────────────────────────────────────────
    // Guests (unauthenticated) redirected
    // ────────────────────────────────────────────

    public function test_guest_redirected_to_login(): void
    {
        $this->get('/management')->assertRedirect('/login');
        $this->get('/management/events')->assertRedirect('/login');
        $this->get('/management/users')->assertRedirect('/login');
    }
}
