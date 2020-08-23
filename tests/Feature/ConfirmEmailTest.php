<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use HappyCasts\User;

class ConfirmEmailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test a user can confirm email
     *
     * @return void
     */
    public function test_a_user_can_confirm_email()
    {
        $this->withoutExceptionHandling();

        //create user
        $user = factory(User::class)->create();

        //make a get request to confirm endpoint
        $this->get("/register/confirm/?token={$user->confirm_token}")
            ->assertRedirect('/')
            ->assertSessionHas('success', 'Your email has been confirmed.');

        //assert that the user is confirmed
        $this->assertTrue($user->fresh()->isConfirmed());
    }

    /**
     * test a user is redirected if token is wrong
     *
     * @return void
     */
    public function test_a_user_is_redirected_if_token_is_wrong()
    {
        //create user
        $user = factory(User::class)->create();

        //make a get request to confirm endpoint
        $this->get("/register/confirm/?token=WRONG_TOKEN")
            ->assertRedirect('/')
            ->assertSessionHas('error', 'Confirmation token not recognised.');
    }
}
