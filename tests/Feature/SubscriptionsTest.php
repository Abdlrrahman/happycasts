<?php

namespace Tests\Feature;

use Tests\TestCase;
use HappyCasts\User;
use HappyCasts\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * create a fake subscription
     *
     * @return void
     */
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

    /**
     * test a user without a plan cannot watch premium lessons
     *
     * @return void
     */
    public function test_a_user_without_a_plan_cannot_watch_premium_lessons()
    {
        //create a user
        $user = factory(User::class)->create();

        //create lessons
        $lesson = factory(Lesson::class)->create(['premium' => 1]);
        $lesson2 = factory(Lesson::class)->create(['premium' => 0]);

        $this->actingAs($user);

        $this->get("/series/{$lesson->series->slug}/lesson/{$lesson->id}")
            ->assertRedirect('/subscribe');

        $this->get("/series/{$lesson2->series->slug}/lesson/{$lesson2->id}")
            ->assertViewIs('watch');
    }

    /**
     * test a user on any plan can watch all lessons
     *
     * @return void
     */
    public function test_a_user_on_any_plan_can_watch_all_lessons()
    {
        //create a user
        $user = factory(User::class)->create();

        //create lessons
        $lesson = factory(Lesson::class)->create(['premium' => 1]);
        $lesson2 = factory(Lesson::class)->create(['premium' => 0]);

        $this->actingAs($user);

        $this->fakeSubscribe($user);

        $this->get("/series/{$lesson->series->slug}/lesson/{$lesson->id}")
            ->assertViewIs('watch');

        $this->get("/series/{$lesson2->series->slug}/lesson/{$lesson2->id}")
            ->assertViewIs('watch');
    }
}
