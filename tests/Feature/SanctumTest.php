<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class SanctumTest extends TestCase
{
    public function testUnauthenticatedUserHasNotAccessToApi(): void
    {
        $response = $this->get(route('v1.user'));

        $response->assertRedirect();
    }

    public function testTokenCanBeReceived(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('sanctum.token.store'), [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'some',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id,
            'name' => 'some',
        ]);
    }

    public function testTokenProvidesAccessToApi(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('some');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
        ])->get(route('v1.user'));

        $response->assertOk()->assertJson($user->toArray());
    }
}
