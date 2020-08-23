<?php

namespace Tests\Unit;

use Redis;
use Tests\TestCase;
use HappyCasts\User;
use HappyCasts\Lesson;
use HappyCasts\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test a user can complete a lesson
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

    /**
     * test a user can get percentage completed for series
     *
     * @return void
     */
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

    /**
     * test can know if a user has started a series
     *
     * @return void
     */
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

    /**
     * test can get completed series lessons
     *
     * @return void
     */
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

    /**
     * test can check if user has completed lesson
     *
     * @return void
     */
    public function test_can_check_if_user_has_completed_lesson()
    {
        $this->flushRedis();
        //create a user
        $user = factory(User::class)->create();

        //create lessons
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create(['series_id' => 1]);

        //complete a lesson 
        $user->completeLesson($lesson);

        $this->assertTrue($user->hasCompletedLesson($lesson));

        $this->assertFalse($user->hasCompletedLesson($lesson2));
    }

    /**
     * test can get all series being watched by user
     *
     * @return void
     */
    public function test_can_get_all_series_being_watched_by_user()
    {
        $this->flushRedis();
        //create a user
        $user = factory(User::class)->create();

        //create lessons
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create(['series_id' => 1]);
        $lesson3 = factory(Lesson::class)->create();
        $lesson4 = factory(Lesson::class)->create(['series_id' => 2]);
        $lesson5 = factory(Lesson::class)->create();
        $lesson6 = factory(Lesson::class)->create(['series_id' => 3]);

        //complete a lesson 
        $user->completeLesson($lesson);
        $user->completeLesson($lesson3);

        $startedSeries = $user->seriesBeingWatched();

        $this->assertInstanceOf(Collection::class, $startedSeries);

        $this->assertInstanceOf(Series::class, $startedSeries->random());

        $idsOfStartedSeries = $startedSeries->pluck('id')->all();

        $this->assertTrue(
            in_array($lesson->series->id, $idsOfStartedSeries)
        );

        $this->assertTrue(
            in_array($lesson3->series->id, $idsOfStartedSeries)
        );

        $this->assertFalse(
            in_array($lesson6->series->id, $idsOfStartedSeries)
        );
    }

    /**
     * test can get number of completed lessons for a user
     *
     * @return void
     */
    public function test_can_get_number_of_completed_lessons_for_a_user()
    {
        $this->flushRedis();
        //create a user
        $user = factory(User::class)->create();

        //create lessons
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create(['series_id' => 1]);
        $lesson3 = factory(Lesson::class)->create();
        $lesson4 = factory(Lesson::class)->create(['series_id' => 2]);
        $lesson5 = factory(Lesson::class)->create(['series_id' => 2]);

        //complete a lesson 
        $user->completeLesson($lesson);
        $user->completeLesson($lesson3);
        $user->completeLesson($lesson5);

        $this->assertEquals(3, $user->getTotalNumberOfCompletedLessons());
    }

    /**
     * test can get next lesson to be watched by user
     *
     * @return void
     */
    public function test_can_get_next_lesson_to_be_watched_by_user()
    {
        $this->flushRedis();
        //create a user
        $user = factory(User::class)->create();

        //create lessons
        $lesson = factory(Lesson::class)->create(['episode_number' => 1]);
        $lesson2 = factory(Lesson::class)->create(['series_id' => 1, 'episode_number' => 2]);
        $lesson3 = factory(Lesson::class)->create(['series_id' => 1, 'episode_number' => 3]);
        $lesson4 = factory(Lesson::class)->create(['series_id' => 1, 'episode_number' => 4]);

        //complete a lesson 
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);

        $nextLesson = $user->getNextLessonToWatch($lesson->series);

        $this->assertEquals($lesson3->id, $nextLesson->id);

        //complete a lesson 
        $user->completeLesson($lesson3);

        $this->assertEquals($lesson4->id, $user->getNextLessonToWatch($lesson->series)->id);
    }
}
