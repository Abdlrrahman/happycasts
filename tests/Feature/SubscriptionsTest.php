<?php

namespace Tests\Feature;

use Tests\TestCase;
use HappyCasts\User;
use HappyCasts\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionsTest extends TestCase
{
    use RefreshDatabase;

    public function fakeSubscribe($user)
    {
        // subscriptions 
        $user->subscriptions()->create([
            'name' => 'yearly',
            'stripe_id' => 'FAKE_STRIPE_ID',
            'stripe_plan' => 'yearly',
            'quantity' => 1
        ]);
    }

    public function test_a_user_without_a_plan_cannot_watch_premium_lessons()
    {

        //create a user
        $user = factory(User::class)->create();

        //create a lesson
        $lesson = factory(Lesson::class)->create(['premium' => 1]);

        $this->actingAs($user);

        $this->get("/series/{$lesson->series->slug}/lesson/{$lesson->id}")
            ->assertRedirect('/subscribe');
    }
}
