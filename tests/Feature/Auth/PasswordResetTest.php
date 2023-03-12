<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function testResetPasswordLinkCanBeRequested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->post(route('v1.auth.password.email'), [
            'email' => $user->email,
        ]);

        $response->assertOk()->assertJson([
            'status' => __(PasswordBroker::RESET_LINK_SENT),
        ]);

        $this->assertDatabaseHas('password_resets', [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function testPasswordCanBeResetWithValidToken(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('v1.auth.password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function (object $notification) use ($user) {
            $response = $this->post(route('v1.auth.password.store'), [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'Password@123',
                'password_confirmation' => 'Password@123',
            ]);

            $response->assertOk()->assertJson([
                'status' => __(PasswordBroker::PASSWORD_RESET),
            ]);

            return true;
        });
    }
}
