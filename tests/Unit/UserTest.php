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

        $this->flushRedis();
        //create user
        $user = factory(User::class)->create();

        //create lessons
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);

        //complete a lesson
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);

        $this->assertEquals(
            Redis::smembers('user:1:series:1'),
            [1, 2]
        );

        $this->assertEquals(
            $user->getNumberOfCompletedLessonsForASeries($lesson->series),
            2
        );
    }

    public function test_a_user_can_get_percentage_completed_for_series()
    {

        $this->flushRedis();
        //create user
        $user = factory(User::class)->create();

        //create lessons
        $lesson = factory(Lesson::class)->create();
        factory(Lesson::class)->create(['series_id' => 1]);
        factory(Lesson::class)->create(['series_id' => 1]);
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);


        //complete a lesson
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);
        $this->assertEquals(
            $user->percentageCompletedForSeries($lesson->series),
            50
        );
    }
}
