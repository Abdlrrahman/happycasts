<?php

namespace HappyCasts\Entities;

use Redis;
use HappyCasts\Lesson;
use HappyCasts\Series;

trait Learning
{

  public function completeLesson($lesson)
  {
    Redis::sadd("user:{$this->id}:series:{$lesson->series->id}", $lesson->id);
  }

  public function getNumberOfCompletedLessonsForASeries($series)
  {
    return count($this->getCompletedLessonsForASeries($series));
  }

  public function percentageCompletedForSeries($series)
  {
    $numberOfLessonsInSeries = $series->lessons->count();
    $numberOfCompletedLessons = $this->getNumberOfCompletedLessonsForASeries($series);

    return ($numberOfCompletedLessons / $numberOfLessonsInSeries) * 100;
  }

  public function hasStartedSeries($series)
  {
    return $this->getNumberOfCompletedLessonsForASeries($series) > 0;
  }

  public function getCompletedLessonsForASeries($series)
  {
    return Redis::smembers("user:{$this->id}:series:{$series->id}");
  }

  public function getCompletedLessons($series)
  {
    $completedLessons = $this->getCompletedLessonsForASeries($series);
    return Lesson::whereIn(
      'id',
      $this->getCompletedLessonsForASeries($series)
    )->get();
  }

  public function hasCompletedLesson($lesson)
  {
    return in_array(
      $lesson->id,
      $this->getCompletedLessonsForASeries($lesson->series)
    );
  }

  public function seriesBeingWatchedIds()
  {
    $keys = Redis::keys("user:{$this->id}:series:*");
    $seriesIds = [];
    foreach ($keys as $key) :
      $seriedId = explode(':', $key)[3];
      array_push($seriesIds, $seriedId);
    endforeach;

    return $seriesIds;
  }

  public function seriesBeingWatched()
  {
    return collect($this->seriesBeingWatchedIds())->map(function ($id) {
      return Series::find($id);
    })->filter();
  }

  public function getTotalNumberOfCompletedLessons()
  {
    $keys = Redis::keys("user:{$this->id}:series:*");
    $result = 0;
    foreach ($keys as $key) :
      $result = $result + count(Redis::smembers($key));
    endforeach;

    return $result;
  }

  public function getNextLessonToWatch($series)
  {
    $lessonIds = $this->getCompletedLessonsForASeries($series);
    $lessonId = end($lessonIds);
    return Lesson::find(
      $lessonId
    )->getNextLesson();
  }
}
