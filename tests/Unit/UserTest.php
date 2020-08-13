<?php

namespace Tests\Unit;

use Redis;
use Tests\TestCase;
use HappyCasts\User;
use HappyCasts\Lesson;
use HappyCasts\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test.
     *
     * @return void
     */
    public function test_a_user_can_complete_a_lesson()
    {
        //create user
        $user = factory(User::class)->create();

        //create series
        $series = factory(Series::class)->create();
        $lesson = factory(Lesson::class)->create([
            'series_id' => $series->id
        ]);

        //complete a lesson
        $user->completeLesson($lesson);
        $this->assertEquals(
            Redis::smembers('user:1:series:1'),
            [1]
        );

        //redis
    }
}
