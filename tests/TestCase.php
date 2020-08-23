<?php

namespace Tests;

use Config;
use Redis;
use HappyCasts\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * login as admin
     *
     * @return void
     */
    public function loginAdmin()
    {
        $user = factory(User::class)->create();

        Config::push('happycasts.administrators', $user->email);

        $this->actingAs($user);
    }

    /**
     * flushes Redis
     *
     * @return void
     */
    public function flushRedis()
    {
        Redis::flushall();
    }
}
