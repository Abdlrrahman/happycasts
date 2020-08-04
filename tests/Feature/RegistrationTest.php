<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_has_a_default_username_after_registration()
    {
        $this->post('/register', [
            'name' => 'bruce wayne',
            'email' => 'bruce.wayne@waynetech.ind',
            'password' => 'secret'
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'username' => str_slug('bruce wayne')
        ]);
    }
}
