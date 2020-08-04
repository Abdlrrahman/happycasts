<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic user test.
     *
     * @return void
     */
    public function test_a_user_receives_correct_message_when_passing_in_wrong_credentials()
    {
        $user = factory(Happycasts\User::class)->create();

        $this->postJson('/Login', [
            'email' => $user->email, 'password' => 'wrong-password'
        ])->assertStatus(422)
            ->assertJson(['message' => 'These credentials do not match our records.']);
    }
}
