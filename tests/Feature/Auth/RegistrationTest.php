<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testNewUsersCanRegister(): void
    {
        Notification::fake();

        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'username',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertNoContent();
        $this->assertAuthenticated();
        $this->assertDatabaseHas(User::class, [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'username',
        ]);

        Notification::assertSentTimes(VerifyEmail::class, 1);
    }
}
