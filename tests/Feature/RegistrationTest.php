<?php

namespace Tests\Feature;

use Mail;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use HappyCasts\Mail\ConfirmYourEmail;
use HappyCasts\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test.
     *
     * @return void
     */
    public function test_a_user_has_a_default_username_after_registration()
    {
        //Register new user
        //assert that after registration the user was redirected
        $this->post('/register', [
            'name' => 'bruce wayne',
            'email' => 'bruce1wayne@waynetech.ind',
            'password' => 'secret'
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'username' => str_slug('bruce wayne')
        ]);
    }

    public function test_an_email_is_sent_to_newly_registered_users()
    {
        $this->withoutExceptionHandling();
        Mail::fake();

        //Register new user
        $this->post('/register', [
            'name' => '1bruce wayne',
            'email' => '1bruce1wayne@waynetech.ind',
            'password' => 'secret'
        ])->assertRedirect();

        //assert that after registration the user was redirected
        Mail::assertQueued(ConfirmYourEmail::class);
    }

    public function test_a_user_has_a_token_after_registration()
    {
        Mail::fake();
        $this->withoutExceptionHandling();
        //Register new user
        $this->post('/register', [
            'name' => 'alex mercer',
            'email' => 'alex.mercer@prototype.inc',
            'password' => 'secret'
        ])->assertRedirect();
        //assert that after registration the user's token is not null
        $user = User::find(1);
        $this->assertNotNull($user->confirm_token);
        $this->assertFalse($user->isConfirmed());
    }
}
