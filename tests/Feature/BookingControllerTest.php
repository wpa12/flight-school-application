<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Booking;
use App\Models\User;
use App\Models\Aircraft;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\Instructor;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\BookableType;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->admin()->create();
    }

    public function test_create_page_is_accessible_to_authenticated_user(): void
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.bookings.create'));

        $response->assertStatus(200);
        $response->assertSee('Create a Booking');
    }

    public function test_create_page_does_not_contain_user_list_for_non_admin_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard.bookings.create'));
        $response->assertStatus(200);
        $response->assertDontSeeHtml('<option value="">Select a user...</option>');
    }

    public function test_create_page_contains_user_list_for_admin_user(): void
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.bookings.create'));
        $response->assertStatus(200);
        $response->assertSeeHtml('<option value="">Select a user...</option>');
    }

    public function test_create_page_contains_correct_content(): void
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.bookings.create'));
        $response->assertStatus(200);
        $response->assertSee('Create a Booking');
    }

    public function test_create_page_shows_bookable_types(): void
    {
        $bookableTypeCases = BookableType::cases();

        $response = $this->actingAs($this->user)->get(route('dashboard.bookings.create'));

        foreach($bookableTypeCases as $type) {
            $response->assertSee($type->label());
        }
    }
}