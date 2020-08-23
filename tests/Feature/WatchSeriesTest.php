<?php

namespace Tests\Feature;

use Tests\TestCase;
use HappyCasts\User;
use HappyCasts\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WatchSeriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test a user can complete a series
     *
     * @return void
     */
    public function test_a_user_can_complete_a_series()
    {
        $this->flushRedis();
        $this->withoutExceptionHandling();

        // create a user 
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // create lessons
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create(['series_id' => 1]);

        // post to complete-lesson route
        $response = $this->post("/series/complete-lesson/{$lesson->id}", []);

        $response->assertStatus(200);

        $response->assertJson([
            'status' => 'ok'
        ]);

        $this->assertTrue(
            $user->hasCompletedLesson($lesson)
        );

        $this->assertFalse(
            $user->hasCompletedLesson($lesson2)
        );
    }
}
