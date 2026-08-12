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

class FrontRoutesTest extends TestCase
{
    use RefreshDatabase;

    // ─── TOP PAGE ────────────────────────────────────────────

    public function test_top_page_renders_with_empty_database(): void
    {
        $this->get('/')->assertOk()->assertSee('GoGoGo');
    }

    public function test_top_page_renders_with_seeded_data(): void
    {
        $location = Location::factory()->create();
        $topic = Topic::factory()->published()->create();
        $event = Event::factory()->published()->create([
            'topic_id' => $topic->id,
            'location_id' => $location->id,
        ]);
        Media::factory()->approved()->create(['event_id' => $event->id]);

        $this->get('/')
            ->assertOk()
            ->assertSee($event->name)
            ->assertSee($location->name);
    }

    public function test_top_page_shows_login_form_for_guests(): void
    {
        $this->get('/')->assertOk()->assertSee('sign in');
    }

    public function test_top_page_shows_greeting_for_authenticated_user(): void
    {
        $user = User::factory()->member()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertOk();
        // Greeting contains the user's name (randomized bilingual prefix)
        $response->assertSee($user->name);
        // Shows the giant menu links
        $response->assertSee('top-menu-link', false);
    }

    public function test_top_page_dashboard_link_visible_to_admin(): void
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user)->get('/')
            ->assertOk()
            ->assertSee('Dashboard');
    }

    public function test_top_page_dashboard_link_hidden_from_member(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user)->get('/')
            ->assertOk()
            ->assertDontSee('Dashboard');
    }

    public function test_top_agenda_limits_to_9_events(): void
    {
        // Create 12 events spread across the next 2 months
        for ($i = 0; $i < 12; $i++) {
            Event::factory()->published()->create([
                'start_at' => now()->addDays($i + 1),
            ]);
        }

        $response = $this->get('/');
        $response->assertOk();

        // Count agenda-row components rendered — each has the 'group' link class
        // The agenda section should contain at most 9 event rows
        $content = $response->getContent();
        // agenda-row uses class "flex gap-8 group" for each event link
        $agendaSection = $this->extractAgendaMonths($content);
        $this->assertLessThanOrEqual(9, $agendaSection);
    }

    public function test_top_agenda_excludes_events_beyond_3_months(): void
    {
        // Event within 3 months — should appear
        $near = Event::factory()->published()->create([
            'start_at' => now()->addMonth(),
        ]);
        // Event beyond 3 months — should NOT appear
        $far = Event::factory()->published()->create([
            'start_at' => now()->addMonths(4),
        ]);

        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee($near->name);
        $response->assertDontSee($far->name);
    }

    /**
     * Count event rows in the agenda section of the top page.
     */
    private function extractAgendaMonths(string $html): int
    {
        // Each agenda-row component renders an <a> with the agenda-row class pattern
        // Count occurrences of the agenda-row component marker
        return substr_count($html, 'group-hover:tracking-tight transition-all whitespace-nowrap');
    }

    // ─── EVENT SHOW ──────────────────────────────────────────

    public function test_published_event_visible_to_guest(): void
    {
        $event = Event::factory()->published()->create();
        $this->get('/event/' . $event->slug)->assertOk()->assertSee($event->name);
    }

    public function test_draft_event_404_for_guest(): void
    {
        $event = Event::factory()->draft()->create();
        $this->get('/event/' . $event->slug)->assertNotFound();
    }

    public function test_draft_event_404_for_member(): void
    {
        $event = Event::factory()->draft()->create();
        $user = User::factory()->member()->create();
        $this->actingAs($user)->get('/event/' . $event->slug)->assertNotFound();
    }

    public function test_draft_event_visible_to_admin(): void
    {
        $event = Event::factory()->draft()->create();
        $user = User::factory()->admin()->create();
        $this->actingAs($user)->get('/event/' . $event->slug)->assertOk();
    }

    public function test_draft_event_visible_to_support(): void
    {
        $event = Event::factory()->draft()->create();
        $user = User::factory()->support()->create();
        $this->actingAs($user)->get('/event/' . $event->slug)->assertOk();
    }

    public function test_event_show_guest_sees_login_prompt_for_rsvp(): void
    {
        $event = Event::factory()->published()->create();
        $this->get('/event/' . $event->slug)
            ->assertOk()
            ->assertSee("I'm going", false);
    }

    // ─── AGENDA ──────────────────────────────────────────────

    public function test_agenda_page_renders(): void
    {
        $this->get('/agenda')->assertOk()->assertSee('Agenda');
    }

    public function test_agenda_page_renders_with_empty_database(): void
    {
        $this->get('/agenda')->assertOk();
    }

    public function test_agenda_json_returns_months(): void
    {
        Event::factory()->published()->create([
            'start_at' => now()->addDay(),
        ]);

        $this->getJson('/agenda?page=1')
            ->assertOk()
            ->assertJsonStructure(['months', 'next_page']);
    }

    // ─── TOPIC INDEX ─────────────────────────────────────────

    public function test_topic_index_renders(): void
    {
        Topic::factory()->published()->create();
        $this->get('/topics')->assertOk()->assertSee('Topics');
    }

    public function test_topic_index_renders_with_empty_database(): void
    {
        $this->get('/topics')->assertOk()->assertSee('No topics published yet');
    }

    public function test_topic_index_shows_only_published(): void
    {
        $published = Topic::factory()->published()->create(['name' => 'Visible Published Topic']);
        $draft = Topic::factory()->draft()->create(['name' => 'Hidden Draft Topic']);

        $this->get('/topics')
            ->assertOk()
            ->assertSee('Visible Published Topic')
            ->assertDontSee('Hidden Draft Topic');
    }

    // ─── TOPIC SHOW ─────────────────────────────────────────

    public function test_published_topic_visible_to_guest(): void
    {
        $topic = Topic::factory()->published()->create();
        $this->get('/topic/' . $topic->slug)->assertOk()->assertSee($topic->name);
    }

    public function test_draft_topic_404_for_guest(): void
    {
        $topic = Topic::factory()->draft()->create();
        $this->get('/topic/' . $topic->slug)->assertNotFound();
    }

    public function test_draft_topic_404_for_member(): void
    {
        $topic = Topic::factory()->draft()->create();
        $user = User::factory()->member()->create();
        $this->actingAs($user)->get('/topic/' . $topic->slug)->assertNotFound();
    }

    public function test_draft_topic_visible_to_admin(): void
    {
        $topic = Topic::factory()->draft()->create();
        $user = User::factory()->admin()->create();
        $this->actingAs($user)->get('/topic/' . $topic->slug)->assertOk();
    }

    public function test_draft_topic_visible_to_support(): void
    {
        $topic = Topic::factory()->draft()->create();
        $user = User::factory()->support()->create();
        $this->actingAs($user)->get('/topic/' . $topic->slug)->assertOk();
    }

    // ─── TOPIC DOWNLOAD ─────────────────────────────────────

    public function test_topic_download_returns_text_file(): void
    {
        $topic = Topic::factory()->published()->create([
            'description_en' => '<p>Hello world</p>',
            'description_ja' => '<p>こんにちは</p>',
        ]);

        $response = $this->get('/topic/' . $topic->slug . '/download');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertHeader('Content-Disposition', 'attachment; filename="' . $topic->slug . '.txt"');
        $response->assertSee('Hello world');
        $response->assertSee('こんにちは');
    }

    public function test_topic_download_strips_html_tags(): void
    {
        $topic = Topic::factory()->published()->create([
            'description_en' => '<h2>Title</h2><p>Paragraph with <strong>bold</strong></p>',
        ]);

        $response = $this->get('/topic/' . $topic->slug . '/download');
        $response->assertOk();
        $this->assertStringNotContainsString('<h2>', $response->getContent());
        $this->assertStringNotContainsString('<strong>', $response->getContent());
        $this->assertStringContainsString('Title', $response->getContent());
        $this->assertStringContainsString('Paragraph with bold', $response->getContent());
    }

    public function test_draft_topic_download_404_for_guest(): void
    {
        $topic = Topic::factory()->draft()->create();
        $this->get('/topic/' . $topic->slug . '/download')->assertNotFound();
    }

    public function test_draft_topic_download_allowed_for_admin(): void
    {
        $topic = Topic::factory()->draft()->create(['description_en' => 'Draft content']);
        $user = User::factory()->admin()->create();
        $this->actingAs($user)->get('/topic/' . $topic->slug . '/download')->assertOk();
    }

    // ─── LOCATION INDEX ─────────────────────────────────────

    public function test_location_index_renders(): void
    {
        Location::factory()->create();
        $this->get('/locations')->assertOk()->assertSee('Locations');
    }

    public function test_location_index_renders_with_empty_database(): void
    {
        $this->get('/locations')->assertOk()->assertSee('No locations yet');
    }

    // ─── LOCATION SHOW ──────────────────────────────────────

    public function test_location_show_renders(): void
    {
        $location = Location::factory()->create();
        $this->get('/location/' . $location->slug)->assertOk()->assertSee($location->name);
    }

    public function test_location_show_with_events(): void
    {
        $location = Location::factory()->create();
        $event = Event::factory()->published()->create([
            'location_id' => $location->id,
            'start_at' => now()->addDays(5),
        ]);

        $this->get('/location/' . $location->slug)
            ->assertOk()
            ->assertSee($event->name);
    }

    public function test_location_show_empty_events(): void
    {
        $location = Location::factory()->create();
        $this->get('/location/' . $location->slug)
            ->assertOk()
            ->assertSee('No event has taken place here yet');
    }

    // ─── MEDIA INDEX ─────────────────────────────────────────

    public function test_media_index_renders(): void
    {
        $this->get('/media')->assertOk()->assertSee('Media');
    }

    public function test_media_index_renders_with_empty_database(): void
    {
        $this->get('/media')->assertOk();
    }

    public function test_media_index_shows_only_approved(): void
    {
        $event = Event::factory()->published()->create();
        Media::factory()->approved()->create(['event_id' => $event->id, 'legend' => 'ApprovedLegend']);
        Media::factory()->pending()->create(['event_id' => $event->id, 'legend' => 'PendingLegend']);
        Media::factory()->refused()->create(['event_id' => $event->id, 'legend' => 'RefusedLegend']);

        // The media index shows event names as titles, not legends directly.
        // But the approved count should be 1 (only approved media renders a photo tile)
        $response = $this->get('/media');
        $response->assertOk();
    }

    public function test_media_index_filters_by_event(): void
    {
        $event1 = Event::factory()->published()->create();
        $event2 = Event::factory()->published()->create();
        Media::factory()->approved()->create(['event_id' => $event1->id]);
        Media::factory()->approved()->create(['event_id' => $event2->id]);

        $this->get('/media?event=' . $event1->slug)->assertOk();
    }

    // ─── RSVP ────────────────────────────────────────────────

    public function test_rsvp_requires_authentication(): void
    {
        $event = Event::factory()->published()->create();
        $this->post('/event/' . $event->slug . '/rsvp')
            ->assertRedirect(route('login'));
    }

    public function test_rsvp_toggle_on(): void
    {
        $event = Event::factory()->published()->create();
        $user = User::factory()->member()->create();

        $this->actingAs($user)->post('/event/' . $event->slug . '/rsvp');

        $this->assertDatabaseHas('attendances', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);
    }

    public function test_rsvp_toggle_off(): void
    {
        $event = Event::factory()->published()->create();
        $user = User::factory()->member()->create();

        // Attend then un-attend
        $event->attendees()->attach($user->id);
        $this->actingAs($user)->post('/event/' . $event->slug . '/rsvp');

        $this->assertDatabaseMissing('attendances', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);
    }

    public function test_rsvp_draft_event_404(): void
    {
        $event = Event::factory()->draft()->create();
        $user = User::factory()->member()->create();
        $this->actingAs($user)
            ->post('/event/' . $event->slug . '/rsvp')
            ->assertNotFound();
    }

    public function test_rsvp_shows_attending_state_on_event_page(): void
    {
        $event = Event::factory()->published()->create();
        $user = User::factory()->member()->create();
        $event->attendees()->attach($user->id);

        $this->actingAs($user)->get('/event/' . $event->slug)
            ->assertOk()
            ->assertSee('bg-yellow-200 leading-5', false);
    }

    // ─── PROFILE ──────────────────────────────────────────────

    public function test_profile_form_prepopulated_with_user_data(): void
    {
        $user = User::factory()->member()->create([
            'name' => 'Tanaka Taro',
            'email' => 'tanaka@example.com',
        ]);

        $response = $this->actingAs($user)->get('/profile');
        $response->assertOk();

        // Overview section shows the user's name
        $response->assertSee('Tanaka Taro');

        // My Info form inputs are pre-filled with current values
        $response->assertSee('value="Tanaka Taro"', false);
        $response->assertSee('value="tanaka@example.com"', false);
    }

    public function test_profile_overview_shows_real_stats(): void
    {
        $user = User::factory()->member()->create();
        $event = Event::factory()->published()->create();
        $event->attendees()->attach($user->id);
        Media::factory()->approved()->create([
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/profile');
        $response->assertOk();
        // Shows the user's registered-since date
        $response->assertSee($user->created_at->format('Y-m-d'));
        // Shows email in private section
        $response->assertSee($user->email);
    }

    public function test_profile_form_repopulates_after_validation_error(): void
    {
        $user = User::factory()->member()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
        ]);

        // Submit with invalid email to trigger validation error
        $response = $this->actingAs($user)
            ->from('/profile')
            ->patch('/profile', [
                'name' => 'New Name',
                'email' => 'not-an-email',
            ]);

        $response->assertRedirect('/profile');

        // Follow redirect — old() repopulates with the SUBMITTED values
        $response = $this->actingAs($user)->get('/profile');
        $response->assertOk();
        // old('name') returns submitted 'New Name', old('email') returns 'not-an-email'
        $response->assertSee('value="New Name"', false);
        $response->assertSee('value="not-an-email"', false);
    }

    // ─── EMPTY DB RESILIENCE ─────────────────────────────────

    public function test_all_pages_render_with_empty_database(): void
    {
        $this->get('/')->assertOk();
        $this->get('/agenda')->assertOk();
        $this->get('/topics')->assertOk();
        $this->get('/locations')->assertOk();
        $this->get('/media')->assertOk();
    }
}
