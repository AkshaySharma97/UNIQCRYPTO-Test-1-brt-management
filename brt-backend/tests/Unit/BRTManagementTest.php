<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\BRT;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BRTManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;
    protected $headers;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a regular user and an admin user
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['is_admin' => true]);

        // Authenticate as user
        $this->headers = [
            'Authorization' => 'Bearer ' . auth()->login($this->user),
            'Accept' => 'application/json',
        ];
    }

    /** @test */
    public function a_user_can_create_a_brt()
    {
        $data = [
            'brt_code' => 'BRT12345',
            'reserved_amount' => 1000,
            'status' => 'reserved',
        ];

        $response = $this->postJson('/api/brts', $data, $this->headers);

        $response->assertStatus(201)
                 ->assertJson([
                     'brt_code' => 'BRT12345',
                     'reserved_amount' => 1000,
                     'status' => 'reserved',
                 ]);

        $this->assertDatabaseHas('brts', ['brt_code' => 'BRT12345']);
    }

    /** @test */
    public function a_user_can_view_all_brts()
    {
        BRT::factory()->count(5)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/brts', $this->headers);

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    /** @test */
    public function a_user_can_view_a_single_brt()
    {
        $brt = BRT::factory()->create(['user_id' => $this->user->id]);

        $response = $this->getJson("/api/brts/{$brt->id}", $this->headers);

        $response->assertStatus(200)
                 ->assertJson([
                     'brt_code' => $brt->brt_code,
                     'reserved_amount' => $brt->reserved_amount,
                     'status' => $brt->status,
                 ]);
    }

    /** @test */
    public function a_user_can_update_a_brt()
    {
        $brt = BRT::factory()->create(['user_id' => $this->user->id]);

        $updateData = [
            'reserved_amount' => 2000,
            'status' => 'confirmed',
        ];

        $response = $this->putJson("/api/brts/{$brt->id}", $updateData, $this->headers);

        $response->assertStatus(200)
                 ->assertJson([
                     'reserved_amount' => 2000,
                     'status' => 'confirmed',
                 ]);

        $this->assertDatabaseHas('brts', ['reserved_amount' => 2000, 'status' => 'confirmed']);
    }

    /** @test */
    public function a_user_can_delete_a_brt()
    {
        $brt = BRT::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/brts/{$brt->id}", [], $this->headers);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'BRT deleted successfully']);

        $this->assertDatabaseMissing('brts', ['id' => $brt->id]);
    }
}