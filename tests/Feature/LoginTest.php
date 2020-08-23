<?php

namespace Tests\Feature;

use HappyCasts\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test correct response after user logs in
     *
     * @return void
     */
    public function test_correct_response_after_user_logs_in()
    {
        $user = factory(User::class)->create();

        $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'secret'
        ], ['X-Requested-With' => 'XMLHttpRequest'])->assertStatus(200)
            ->assertJson([
                'status' => 'ok'
            ])->assertSessionHas('success', 'Successfully logged in.');
    }

    /**
     * test a user receives correct message when passing in wrong credentials
     *
     * @return void
     */
    public function test_a_user_receives_correct_message_when_passing_in_wrong_credentials()
    {
        $user = factory(User::class)->create();

        $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ])->assertStatus(422)
            ->assertJson([
                'message' => 'These credentials do not match our records.'
            ]);
    }
}
