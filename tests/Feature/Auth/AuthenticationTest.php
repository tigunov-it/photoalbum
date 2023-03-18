<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanAuthenticate(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('v1.auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertNoContent();
        $this->assertAuthenticated();
    }

    public function testUsersCanNotAuthenticateWithInvalidPassword(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('v1.auth.login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertUnprocessable()->assertJson([
            'errors' => ['email' => [__('auth.failed')]]
        ]);
        $this->assertGuest();
    }
}
