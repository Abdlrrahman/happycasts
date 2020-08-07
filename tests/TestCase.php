<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Config;
use HappyCasts\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loginAdmin()
    {
        $user = factory(User::class)->create();

        Config::push('happycasts.administrators', $user->email);

        $this->actingAs($user);
    }
}
