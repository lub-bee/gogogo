<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MakeAdminCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_make_admin_creates_admin_user_interactively(): void
    {
        $this->artisan('app:make-admin')
            ->expectsQuestion('Name', 'Admin User')
            ->expectsQuestion('Email', 'admin@example.com')
            ->expectsQuestion('Password', 'securepassword123')
            ->assertExitCode(0);

        $user = User::where('email', 'admin@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('admin', $user->rank);
        $this->assertEquals('Admin User', $user->name);
        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isSupport());
    }

    public function test_make_admin_creates_admin_user_with_options(): void
    {
        putenv('ADMIN_PASSWORD=securepassword123');

        $this->artisan('app:make-admin', [
            '--name' => 'CI Admin',
            '--email' => 'ci-admin@example.com',
            '--password-stdin' => true,
        ])
            ->assertExitCode(0);

        $user = User::where('email', 'ci-admin@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('admin', $user->rank);
        $this->assertTrue($user->isAdmin());

        putenv('ADMIN_PASSWORD');
    }

    public function test_make_admin_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $this->artisan('app:make-admin')
            ->expectsQuestion('Name', 'Admin')
            ->expectsQuestion('Email', 'existing@example.com')
            ->expectsQuestion('Password', 'securepassword123')
            ->assertExitCode(1);
    }

    public function test_make_admin_fails_with_short_password(): void
    {
        $this->artisan('app:make-admin')
            ->expectsQuestion('Name', 'Admin')
            ->expectsQuestion('Email', 'short@example.com')
            ->expectsQuestion('Password', 'short')
            ->assertExitCode(1);
    }

    public function test_make_admin_fails_with_invalid_email(): void
    {
        $this->artisan('app:make-admin')
            ->expectsQuestion('Name', 'Admin')
            ->expectsQuestion('Email', 'not-an-email')
            ->expectsQuestion('Password', 'securepassword123')
            ->assertExitCode(1);
    }

    public function test_make_admin_fails_with_missing_name(): void
    {
        $this->artisan('app:make-admin')
            ->expectsQuestion('Name', '')
            ->expectsQuestion('Email', 'test@example.com')
            ->expectsQuestion('Password', 'securepassword123')
            ->assertExitCode(1);
    }
}
