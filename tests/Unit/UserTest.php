<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\BRT;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    /** @test */
    public function it_can_have_multiple_brts()
    {
        $user = User::factory()->create();
        BRT::factory()->count(3)->create(['user_id' => $user->id]);

        $this->assertCount(3, $user->brts);
    }

    /** @test */
    public function it_returns_correct_jwt_identifier()
    {
        $user = User::factory()->create();
        $this->assertEquals($user->id, $user->getJWTIdentifier());
    }

    /** @test */
    public function it_returns_empty_jwt_custom_claims()
    {
        $user = User::factory()->create();
        $this->assertEquals([], $user->getJWTCustomClaims());
    }
}