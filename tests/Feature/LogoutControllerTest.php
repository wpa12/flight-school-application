<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_logout_redirects_to_login_page(): void
    {
        $this->actingAs($this->user)->post(route('dashboard.logout'))->assertRedirect(route('login'));
    }

    public function test_logout_invalidates_session(): void
    {
        $this->actingAs($this->user)->post(route('dashboard.logout'));
        $this->assertGuest();
        $this->assertNull(session()->get('user_id'));
    }
}