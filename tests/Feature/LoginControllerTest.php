<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $password = 'password';

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    public function test_login_page_contains_correct_content(): void
    {
        $response = $this->get(route('login'));
        $response->assertSee('Login');
    }

    public function test_login_page_redirects_to_dashboard_if_authenticated(): void
    {
        $this->actingAs($this->user)->get(route('login'))->assertRedirect(route('dashboard.index'));
    }

    public function test_login_with_invalid_credentials(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
            'remember' => false,
        ]);

        $response->assertStatus(302);
        $response->assertRedirectBackWithErrors(['email' => 'Invalid credentials']);
    }
}