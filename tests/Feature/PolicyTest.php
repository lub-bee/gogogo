<?php

namespace Tests\Feature;

use App\Enums\MediaStatus;
use App\Models\Event;
use App\Models\Location;
use App\Models\Media;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $support;
    private User $member;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->support = User::factory()->support()->create();
        $this->member = User::factory()->member()->create();
    }

    // ==================== EventPolicy ====================

    public function test_admin_can_do_everything_on_events(): void
    {
        $draft = Event::factory()->draft()->create();
        $published = Event::factory()->published()->create();

        $this->assertTrue($this->admin->can('view', $draft));
        $this->assertTrue($this->admin->can('view', $published));
        $this->assertTrue($this->admin->can('create', Event::class));
        $this->assertTrue($this->admin->can('update', $draft));
        $this->assertTrue($this->admin->can('delete', $draft));
    }

    public function test_support_can_manage_events(): void
    {
        $draft = Event::factory()->draft()->create();

        $this->assertTrue($this->support->can('view', $draft));
        $this->assertTrue($this->support->can('create', Event::class));
        $this->assertTrue($this->support->can('update', $draft));
        $this->assertTrue($this->support->can('delete', $draft));
    }

    public function test_member_can_view_published_events_only(): void
    {
        $draft = Event::factory()->draft()->create();
        $published = Event::factory()->published()->create();

        $this->assertFalse($this->member->can('view', $draft));
        $this->assertTrue($this->member->can('view', $published));
        $this->assertFalse($this->member->can('create', Event::class));
        $this->assertFalse($this->member->can('update', $published));
        $this->assertFalse($this->member->can('delete', $published));
    }

    public function test_member_cannot_view_scheduled_event(): void
    {
        $scheduled = Event::factory()->scheduled()->create();

        $this->assertFalse($this->member->can('view', $scheduled));
    }

    // ==================== TopicPolicy ====================

    public function test_admin_can_do_everything_on_topics(): void
    {
        $topic = Topic::factory()->draft()->create();

        $this->assertTrue($this->admin->can('view', $topic));
        $this->assertTrue($this->admin->can('create', Topic::class));
        $this->assertTrue($this->admin->can('update', $topic));
        $this->assertTrue($this->admin->can('delete', $topic));
    }

    public function test_support_can_manage_topics(): void
    {
        $topic = Topic::factory()->draft()->create();

        $this->assertTrue($this->support->can('view', $topic));
        $this->assertTrue($this->support->can('create', Topic::class));
        $this->assertTrue($this->support->can('update', $topic));
        $this->assertTrue($this->support->can('delete', $topic));
    }

    public function test_member_topic_permissions(): void
    {
        $draft = Topic::factory()->draft()->create();
        $published = Topic::factory()->published()->create();

        $this->assertFalse($this->member->can('view', $draft));
        $this->assertTrue($this->member->can('view', $published));
        $this->assertFalse($this->member->can('create', Topic::class));
        $this->assertFalse($this->member->can('update', $published));
        $this->assertFalse($this->member->can('delete', $published));
    }

    // ==================== LocationPolicy ====================

    public function test_admin_can_manage_locations(): void
    {
        $location = Location::factory()->create();

        $this->assertTrue($this->admin->can('view', $location));
        $this->assertTrue($this->admin->can('create', Location::class));
        $this->assertTrue($this->admin->can('update', $location));
        $this->assertTrue($this->admin->can('delete', $location));
    }

    public function test_support_can_manage_locations(): void
    {
        $location = Location::factory()->create();

        $this->assertTrue($this->support->can('create', Location::class));
        $this->assertTrue($this->support->can('update', $location));
        $this->assertTrue($this->support->can('delete', $location));
    }

    public function test_member_can_only_view_locations(): void
    {
        $location = Location::factory()->create();

        $this->assertTrue($this->member->can('view', $location));
        $this->assertFalse($this->member->can('create', Location::class));
        $this->assertFalse($this->member->can('update', $location));
        $this->assertFalse($this->member->can('delete', $location));
    }

    // ==================== MediaPolicy ====================

    public function test_admin_full_media_access(): void
    {
        $media = Media::factory()->create();

        $this->assertTrue($this->admin->can('create', Media::class));
        $this->assertTrue($this->admin->can('update', $media));
        $this->assertTrue($this->admin->can('delete', $media));
    }

    public function test_support_can_manage_media(): void
    {
        $media = Media::factory()->create();

        $this->assertTrue($this->support->can('create', Media::class));
        $this->assertTrue($this->support->can('update', $media));
        $this->assertTrue($this->support->can('delete', $media));
    }

    public function test_member_can_create_but_not_manage_media(): void
    {
        $media = Media::factory()->create();

        $this->assertTrue($this->member->can('create', Media::class));
        $this->assertFalse($this->member->can('update', $media));
        $this->assertFalse($this->member->can('delete', $media));
    }

    // ==================== UserPolicy ====================

    public function test_admin_can_manage_users(): void
    {
        $this->assertTrue($this->admin->can('viewAny', User::class));
        $this->assertTrue($this->admin->can('view', $this->member));
        $this->assertTrue($this->admin->can('create', User::class));
        $this->assertTrue($this->admin->can('update', $this->member));
        $this->assertTrue($this->admin->can('delete', $this->member));
    }

    public function test_admin_cannot_delete_self(): void
    {
        $this->assertFalse($this->admin->can('delete', $this->admin));
    }

    public function test_support_cannot_manage_users(): void
    {
        $this->assertFalse($this->support->can('viewAny', User::class));
        $this->assertFalse($this->support->can('create', User::class));
        $this->assertFalse($this->support->can('update', $this->member));
        $this->assertFalse($this->support->can('delete', $this->member));
    }

    public function test_support_can_view_self(): void
    {
        $this->assertTrue($this->support->can('view', $this->support));
    }

    public function test_member_cannot_manage_users(): void
    {
        $this->assertFalse($this->member->can('viewAny', User::class));
        $this->assertFalse($this->member->can('create', User::class));
        $this->assertFalse($this->member->can('update', $this->support));
    }

    public function test_member_can_view_self(): void
    {
        $this->assertTrue($this->member->can('view', $this->member));
    }
}
