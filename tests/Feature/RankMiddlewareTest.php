<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RankMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Register test routes for middleware testing
        Route::middleware(['auth', 'rank:admin'])->get('/test-admin-only', function () {
            return response('admin-ok');
        });

        Route::middleware(['auth', 'rank:admin,support'])->get('/test-admin-support', function () {
            return response('staff-ok');
        });

        Route::middleware(['auth', 'rank:support'])->get('/test-support-only', function () {
            return response('support-ok');
        });
    }

    public function test_admin_can_access_admin_route(): void
    {
        $admin = User::factory()->create(['rank' => 'admin']);

        $this->actingAs($admin)
            ->get('/test-admin-only')
            ->assertOk()
            ->assertSee('admin-ok');
    }

    public function test_support_cannot_access_admin_route(): void
    {
        $support = User::factory()->create(['rank' => 'support']);

        $this->actingAs($support)
            ->get('/test-admin-only')
            ->assertForbidden();
    }

    public function test_member_cannot_access_admin_route(): void
    {
        $member = User::factory()->create(['rank' => 'member']);

        $this->actingAs($member)
            ->get('/test-admin-only')
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_support_route(): void
    {
        $admin = User::factory()->create(['rank' => 'admin']);

        $this->actingAs($admin)
            ->get('/test-admin-support')
            ->assertOk()
            ->assertSee('staff-ok');
    }

    public function test_support_can_access_admin_support_route(): void
    {
        $support = User::factory()->create(['rank' => 'support']);

        $this->actingAs($support)
            ->get('/test-admin-support')
            ->assertOk()
            ->assertSee('staff-ok');
    }

    public function test_member_cannot_access_admin_support_route(): void
    {
        $member = User::factory()->create(['rank' => 'member']);

        $this->actingAs($member)
            ->get('/test-admin-support')
            ->assertForbidden();
    }

    public function test_guest_is_redirected(): void
    {
        $this->get('/test-admin-only')
            ->assertRedirect('/login');
    }

    public function test_support_can_access_support_only_route(): void
    {
        $support = User::factory()->create(['rank' => 'support']);

        $this->actingAs($support)
            ->get('/test-support-only')
            ->assertOk()
            ->assertSee('support-ok');
    }

    public function test_admin_cannot_access_support_only_route(): void
    {
        $admin = User::factory()->create(['rank' => 'admin']);

        $this->actingAs($admin)
            ->get('/test-support-only')
            ->assertForbidden();
    }
}
