<?php

namespace Tests\Feature;

use App\Enums\MediaStatus;
use App\Models\Event;
use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadTest extends TestCase
{
    use RefreshDatabase;

    // ------------------------------------------------------------------
    // Upload validation
    // ------------------------------------------------------------------

    public function test_guest_cannot_upload(): void
    {
        $event = Event::factory()->published()->create();

        $response = $this->post(route('media.upload'), [
            'images' => [UploadedFile::fake()->image('photo.jpg')],
            'event_id' => $event->id,
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_upload_requires_images(): void
    {
        $user = User::factory()->member()->create();

        $response = $this->actingAs($user)->post(route('media.upload'), [
            'event_id' => 1,
        ]);

        $response->assertSessionHasErrors('images');
    }

    public function test_upload_rejects_invalid_mime(): void
    {
        $user = User::factory()->member()->create();
        $event = Event::factory()->published()->create();

        $response = $this->actingAs($user)->post(route('media.upload'), [
            'images' => [UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf')],
            'event_id' => $event->id,
        ]);

        $response->assertSessionHasErrors('images.0');
    }

    public function test_upload_rejects_oversized_file(): void
    {
        $user = User::factory()->member()->create();
        $event = Event::factory()->published()->create();

        // 25 MB (over 20 MB limit)
        $response = $this->actingAs($user)->post(route('media.upload'), [
            'images' => [UploadedFile::fake()->image('big.jpg')->size(25600)],
            'event_id' => $event->id,
        ]);

        $response->assertSessionHasErrors('images.0');
    }

    public function test_upload_requires_valid_event(): void
    {
        $user = User::factory()->member()->create();

        $response = $this->actingAs($user)->post(route('media.upload'), [
            'images' => [UploadedFile::fake()->image('photo.jpg')],
            'event_id' => 99999,
        ]);

        $response->assertSessionHasErrors('event_id');
    }

    // ------------------------------------------------------------------
    // Image pipeline
    // ------------------------------------------------------------------

    public function test_upload_creates_webp_and_thumbnail(): void
    {
        Storage::fake('public');

        $user = User::factory()->member()->create();
        $event = Event::factory()->published()->create();

        $response = $this->actingAs($user)->post(route('media.upload'), [
            'images' => [UploadedFile::fake()->image('photo.jpg', 2400, 1600)],
            'event_id' => $event->id,
            'legend' => 'Test photo',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'media-uploaded');

        // Media record created
        $media = Media::first();
        $this->assertNotNull($media);
        $this->assertEquals(MediaStatus::Pending, $media->status);
        $this->assertEquals($user->id, $media->user_id);
        $this->assertEquals($event->id, $media->event_id);
        $this->assertEquals('Test photo', $media->legend);

        // Files exist on disk
        Storage::disk('public')->assertExists($media->path);
        Storage::disk('public')->assertExists($media->thumbnail_path);

        // Files are WebP
        $this->assertStringEndsWith('.webp', $media->path);
        $this->assertStringEndsWith('.webp', $media->thumbnail_path);

        // Paths are in the right directories
        $this->assertStringStartsWith('media/', $media->path);
        $this->assertStringStartsWith('media/thumbs/', $media->thumbnail_path);
    }

    public function test_upload_multiple_files(): void
    {
        Storage::fake('public');

        $user = User::factory()->member()->create();
        $event = Event::factory()->published()->create();

        $response = $this->actingAs($user)->post(route('media.upload'), [
            'images' => [
                UploadedFile::fake()->image('photo1.jpg', 800, 600),
                UploadedFile::fake()->image('photo2.png', 640, 480),
            ],
            'event_id' => $event->id,
        ]);

        $response->assertRedirect();
        $this->assertEquals(2, Media::count());
    }

    // ------------------------------------------------------------------
    // Moderation transitions
    // ------------------------------------------------------------------

    public function test_approve_sets_status(): void
    {
        $media = Media::factory()->pending()
            ->for(User::factory()->member())
            ->for(Event::factory()->published())
            ->create();

        $media->approve();
        $media->refresh();

        $this->assertEquals(MediaStatus::Approved, $media->status);
    }

    public function test_refuse_deletes_original_file(): void
    {
        Storage::fake('public');

        $path = 'media/test-uuid.webp';
        $thumbPath = 'media/thumbs/test-uuid.webp';
        Storage::disk('public')->put($path, 'fake-image-data');
        Storage::disk('public')->put($thumbPath, 'fake-thumb-data');

        $media = Media::factory()->pending()
            ->for(User::factory()->member())
            ->for(Event::factory()->published())
            ->create([
                'path' => $path,
                'thumbnail_path' => $thumbPath,
            ]);

        $media->refuse();
        $media->refresh();

        // Status is refused
        $this->assertEquals(MediaStatus::Refused, $media->status);

        // Original file deleted
        Storage::disk('public')->assertMissing($path);

        // Thumbnail kept
        Storage::disk('public')->assertExists($thumbPath);

        // Path column nulled
        $this->assertNull($media->path);

        // Thumbnail path still set
        $this->assertEquals($thumbPath, $media->thumbnail_path);
    }

    // ------------------------------------------------------------------
    // Moderation access control
    // ------------------------------------------------------------------

    public function test_member_cannot_access_moderation(): void
    {
        $user = User::factory()->member()->create();

        $response = $this->actingAs($user)->get(route('management.media'));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_moderation(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->get(route('management.media'));

        $response->assertOk();
    }

    public function test_support_can_access_moderation(): void
    {
        $user = User::factory()->support()->create();

        $response = $this->actingAs($user)->get(route('management.media'));

        $response->assertOk();
    }

    public function test_guest_cannot_access_moderation(): void
    {
        $response = $this->get(route('management.media'));

        $response->assertRedirect(route('login'));
    }

    // ------------------------------------------------------------------
    // Moderation actions via routes
    // ------------------------------------------------------------------

    public function test_admin_can_approve_via_route(): void
    {
        $admin = User::factory()->admin()->create();
        $media = Media::factory()->pending()
            ->for(User::factory()->member())
            ->for(Event::factory()->published())
            ->create();

        $response = $this->actingAs($admin)->post(route('management.media.approve', $media));

        $response->assertRedirect();
        $media->refresh();
        $this->assertEquals(MediaStatus::Approved, $media->status);
    }

    public function test_admin_can_refuse_via_route(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        Storage::disk('public')->put('media/test.webp', 'data');
        $media = Media::factory()->pending()
            ->for(User::factory()->member())
            ->for(Event::factory()->published())
            ->create(['path' => 'media/test.webp']);

        $response = $this->actingAs($admin)->post(route('management.media.refuse', $media));

        $response->assertRedirect();
        $media->refresh();
        $this->assertEquals(MediaStatus::Refused, $media->status);
        $this->assertNull($media->path);
        Storage::disk('public')->assertMissing('media/test.webp');
    }

    public function test_member_cannot_approve_via_route(): void
    {
        $member = User::factory()->member()->create();
        $media = Media::factory()->pending()
            ->for(User::factory()->member())
            ->for(Event::factory()->published())
            ->create();

        $response = $this->actingAs($member)->post(route('management.media.approve', $media));

        $response->assertStatus(403);
    }

    // ------------------------------------------------------------------
    // Bulk moderation
    // ------------------------------------------------------------------

    public function test_bulk_approve(): void
    {
        $admin = User::factory()->admin()->create();
        $media1 = Media::factory()->pending()
            ->for(User::factory()->member())
            ->for(Event::factory()->published())
            ->create();
        $media2 = Media::factory()->pending()
            ->for(User::factory()->member())
            ->for(Event::factory()->published())
            ->create();

        $response = $this->actingAs($admin)->post(route('management.media.bulk'), [
            'action' => 'approve',
            'media_ids' => [$media1->id, $media2->id],
        ]);

        $response->assertRedirect();
        $media1->refresh();
        $media2->refresh();
        $this->assertEquals(MediaStatus::Approved, $media1->status);
        $this->assertEquals(MediaStatus::Approved, $media2->status);
    }

    public function test_bulk_refuse(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        Storage::disk('public')->put('media/a.webp', 'data');
        Storage::disk('public')->put('media/b.webp', 'data');
        $media1 = Media::factory()->pending()
            ->for(User::factory()->member())
            ->for(Event::factory()->published())
            ->create(['path' => 'media/a.webp']);
        $media2 = Media::factory()->pending()
            ->for(User::factory()->member())
            ->for(Event::factory()->published())
            ->create(['path' => 'media/b.webp']);

        $response = $this->actingAs($admin)->post(route('management.media.bulk'), [
            'action' => 'refuse',
            'media_ids' => [$media1->id, $media2->id],
        ]);

        $response->assertRedirect();
        $media1->refresh();
        $media2->refresh();
        $this->assertEquals(MediaStatus::Refused, $media1->status);
        $this->assertEquals(MediaStatus::Refused, $media2->status);
        Storage::disk('public')->assertMissing('media/a.webp');
        Storage::disk('public')->assertMissing('media/b.webp');
    }

    // ------------------------------------------------------------------
    // Gallery event filter
    // ------------------------------------------------------------------

    public function test_media_index_filters_by_event_slug(): void
    {
        $event1 = Event::factory()->published()->create();
        $event2 = Event::factory()->published()->create();

        Media::factory()->approved()->for(User::factory()->member())
            ->for($event1)->create();
        Media::factory()->approved()->for(User::factory()->member())
            ->for($event1)->create();
        Media::factory()->approved()->for(User::factory()->member())
            ->for($event2)->create();

        // Unfiltered: all 3
        $response = $this->get(route('media.index'));
        $response->assertOk();
        $this->assertCount(3, $response->viewData('photos'));

        // Filtered by event1 slug: only 2
        $response = $this->get(route('media.index', ['event' => $event1->slug]));
        $response->assertOk();
        $this->assertCount(2, $response->viewData('photos'));
        $this->assertNotNull($response->viewData('filteredEvent'));
        $this->assertEquals($event1->id, $response->viewData('filteredEvent')->id);
    }

    public function test_media_index_shows_filter_indicator(): void
    {
        $event = Event::factory()->published()->create(['name' => 'BBQ Party']);
        Media::factory()->approved()->for(User::factory()->member())
            ->for($event)->create();

        $response = $this->get(route('media.index', ['event' => $event->slug]));
        $response->assertOk();
        $response->assertSee('BBQ Party');
        $response->assertSee(route('media.index'));  // "See all" link present
    }

    public function test_event_show_media_button_links_to_filtered_gallery(): void
    {
        $event = Event::factory()->published()->create();

        $response = $this->get(route('event.show', $event));
        $response->assertOk();
        $response->assertSee(route('media.index', ['event' => $event->slug]));
    }

    // ------------------------------------------------------------------
    // Upload button visibility (date-gated)
    // ------------------------------------------------------------------

    public function test_upload_button_visible_on_past_event(): void
    {
        $user = User::factory()->member()->create();
        // Event 3 days ago — clearly past in any timezone
        $event = Event::factory()->published()->create([
            'start_at' => now()->subDays(3),
        ]);

        $response = $this->actingAs($user)->get(route('event.show', $event));
        $response->assertOk();
        $response->assertSee('Upload');
    }

    public function test_upload_button_hidden_on_future_event(): void
    {
        $user = User::factory()->member()->create();
        // Event 5 days from now — clearly future in any timezone
        $event = Event::factory()->published()->create([
            'start_at' => now()->addDays(5),
        ]);

        $response = $this->actingAs($user)->get(route('event.show', $event));
        $response->assertOk();
        $response->assertDontSee('Upload');
    }

    public function test_upload_button_hidden_for_guests(): void
    {
        $event = Event::factory()->published()->create([
            'start_at' => now()->subDays(3),
        ]);

        $response = $this->get(route('event.show', $event));
        $response->assertOk();
        $response->assertDontSee('Upload');
    }

    // ------------------------------------------------------------------
    // RSVP toggle label
    // ------------------------------------------------------------------

    public function test_rsvp_shows_im_going_when_not_attending(): void
    {
        $user = User::factory()->member()->create();
        $event = Event::factory()->published()->create();

        $response = $this->actingAs($user)->get(route('event.show', $event));
        $response->assertOk();
        $response->assertSee("I&#039;m going", false);
        $response->assertDontSee("I&#039;m not going", false);
    }

    public function test_rsvp_shows_im_not_going_when_attending(): void
    {
        $user = User::factory()->member()->create();
        $event = Event::factory()->published()->create();
        $event->attendees()->attach($user);

        $response = $this->actingAs($user)->get(route('event.show', $event));
        $response->assertOk();
        $response->assertSee("I&#039;m not going", false);
    }

    public function test_rsvp_icon_walking_luggage_flipped_when_attending(): void
    {
        $user = User::factory()->member()->create();
        $event = Event::factory()->published()->create();
        $event->attendees()->attach($user);

        $response = $this->actingAs($user)->get(route('event.show', $event));
        $response->assertOk();
        $response->assertSee('fa-person-walking-luggage fa-flip-horizontal', false);
        $response->assertDontSee('fa-person-hiking', false);
    }

    public function test_rsvp_icon_hiking_when_not_attending(): void
    {
        $user = User::factory()->member()->create();
        $event = Event::factory()->published()->create();

        $response = $this->actingAs($user)->get(route('event.show', $event));
        $response->assertOk();
        $response->assertSee('fa-person-hiking', false);
        $response->assertDontSee('fa-flip-horizontal', false);
    }
}
