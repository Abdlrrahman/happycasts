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
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_confirm_email()
    {
        $this->withoutExceptionHandling();
        //create user
        //make a get request to confirm endpoint
        //assert that the user is confirmed
        $user = factory(User::class)->create();

        $this->get("/reguster/confirm/?token={$user->confirm_token}")
            ->asssertRedirect('/');
        $this->assertTrue($user->fresh()->isConfirmed());
    }
}
