<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_registration_page_is_accessible(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register');
    }

    public function test_registration_page_contains_correct_content(): void
    {
        $response = $this->get('/register');
        $response->assertSee('Register');
    }

    public function test_registration_page_redirects_to_dashboard_page_if_authenticated(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/register')->assertRedirect(route('dashboard'));
    }
}