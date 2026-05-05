<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Aircraft;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Database\Seeders\FuelTypeSeeder;
use Database\Seeders\EngineTypeSeeder;

class AircraftControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->admin()->create(); // Create the admin user via the factory
    }

    public function test_show_page_is_accessible_to_admin_user(): void
    {
        // Arrange
        $this->seedDatabase();
        $aircraft = Aircraft::factory()->create();
        
        // Act
        $response = $this->actingAs($this->user)->get(route('dashboard.aircraft.show', $aircraft));

        // Assert
        $response->assertStatus(200);
    }

    public function test_show_page_throws_403_for_non_admin_user(): void
    {
        // Arrange
        $this->seedDatabase();
        $aircraft = Aircraft::factory()->create();

        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get(route('dashboard.aircraft.show', $aircraft));

        // Assert
        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertSee('Forbidden');
        $response->assertStatus(403);
    }

    public function test_edit_page_is_accessible_to_admin_user(): void
    {
        $this->seedDatabase();
        $aircraft = Aircraft::factory()->create();
        
        $this->actingAs($this->user)->get(route('dashboard.aircraft.edit', $aircraft))->assertStatus(200);
    }

    public function test_edit_page_throws_403_for_non_admin_user(): void
    {
        $this->seedDatabase();
        $aircraft = Aircraft::factory()->create();

        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('dashboard.aircraft.edit', $aircraft));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertSee('Forbidden');
    }

    public function test_updating_aircraft_is_successful_for_admin_user(): void
    {
        // Arrange
        $this->seedDatabase();
        $aircraft = Aircraft::factory()->create();

        $data = [
            'type' => $aircraft->type,
            'make' => $aircraft->make,
            'model' => $aircraft->model,
            'description' => $aircraft->description,
            'registration' => $aircraft->registration,
            'rental_price_per_hour' => 100,
            'in_service' => $aircraft->in_service,
            'current_hours' => $aircraft->current_hours,
            'image_url' => $aircraft->image_url,
        ];

        // Act
        $response = $this->actingAs($this->user)->put(route('dashboard.aircraft.update', $aircraft), $data);

        // Assert
        $this->assertDatabaseHas('aircraft', [
            'id' => $aircraft->id,
            'rental_price_per_hour' => 100,
        ]);
        $response->assertRedirect(route('dashboard.aircraft.show', $aircraft));
        $response->assertSessionHas('status', 'Aircraft updated successfully');
    }

    public function test_updating_aircraft_throws_validation_errors_for_admin_user(): void
    {
        // Arrange
        $this->seedDatabase();
        $aircraft = Aircraft::factory()->create();

        $data = [
            ...$aircraft->toArray(),
            'rental_price_per_hour' => -1,
        ];

        // Act
        $response = $this->actingAs($this->user)->put(route('dashboard.aircraft.update', $aircraft), $data);

        // Assert
        $response->assertSessionHasErrors('rental_price_per_hour');
    }

    public function test_updating_aircraft_throws_403_for_non_admin_user(): void
    {
        // Arrange
        $this->seedDatabase();
        $aircraft = Aircraft::factory()->create();

        $user = User::factory()->create();

        $data = [
            ...$aircraft->toArray(),
            'rental_price_per_hour' => 100,
        ];

        // Act
        $response = $this->actingAs($user)->put(route('dashboard.aircraft.update', $aircraft), $data);

        // Assert
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_deleting_aircraft_is_successful_for_admin_user(): void
    {
        // Arrange
        $this->seedDatabase();
        $aircraft = Aircraft::factory()->create();

        // Act
        $response = $this->actingAs($this->user)->delete(route('dashboard.aircraft.delete', $aircraft));

        // Assert
        $this->assertDatabaseMissing('aircraft', $aircraft->toArray());
        $response->assertStatus(302);
        $response->assertRedirect(route('dashboard.index'));
        $response->assertSessionHas('status', 'Aircraft removed from the fleet.');
    }

    // seed the database for the Aircraft::factory to work
    private function seedDatabase(): void
    {
        $this->seed([FuelTypeSeeder::class, EngineTypeSeeder::class]);
    }
}
