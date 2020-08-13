<?php

namespace Tests;

use Config;
use Redis;
use HappyCasts\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loginAdmin()
    {
        $user = factory(User::class)->create();

        Config::push('happycasts.administrators', $user->email);

        $this->actingAs($user);
    }

    public function flushRedis()
    {
        Redis::flushall();
    }
}
