<?php

namespace Tests\Unit;

use Redis;
use Tests\TestCase;
use HappyCasts\User;
use HappyCasts\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

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
        //create a user
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
        //create a user
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

    public function test_can_know_if_a_user_has_started_a_series()
    {
        $this->flushRedis();

        //create a user
        $user = factory(User::class)->create();

        //create lessons
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $lesson3 = factory(Lesson::class)->create();

        //complete a lesson
        $user->completeLesson($lesson2);


        $this->assertTrue($user->hasStartedSeries($lesson->series));

        $this->assertFalse($user->hasStartedSeries($lesson3->series));
    }

    public function test_can_get_completed_series_lessons()
    {
        $this->flushRedis();

        //create a user
        $user = factory(User::class)->create();

        //create lessons
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $lesson3 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);

        //complete lessons
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);

        $completedLessons = $user->getCompletedLessons($lesson->series);


        $this->assertINstanceOf(Collection::class, $completedLessons);

        $this->assertInstanceOf(Lesson::class, $completedLessons->random());

        $completedLessonsIds = $completedLessons->pluck('id')->all();

        $this->assertTrue(in_array($lesson->id, $completedLessonsIds));

        $this->assertTrue(in_array($lesson2->id, $completedLessonsIds));

        $this->assertFalse(in_array($lesson3->id, $completedLessonsIds));
    }
}