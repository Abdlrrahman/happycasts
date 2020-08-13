<?php

namespace HappyCasts\Entities;

use Redis;
use HappyCasts\Lesson;

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
    return collect($completedLessons)->map(function ($lessonId) {
      return Lesson::find($lessonId);
    });
  }
}
