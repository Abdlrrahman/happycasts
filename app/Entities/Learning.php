<?php

namespace HappyCasts\Entities;

use Redis;

trait Learning
{

  public function completeLesson($lesson)
  {
    Redis::sadd("user:{$this->id}:series:{$lesson->series->id}", $lesson->id);
  }

  public function getNumberOfCompletedLessonsForASeries($series)
  {
    return count(Redis::smembers("user:{$this->id}:series:{$series->id}"));
  }


  public function percentageCompletedForSeries($series)
  {
    $numberOfLessonsInSeries = $series->lessons->count();
    $numberOfCompletedLessons = $this->getNumberOfCompletedLessonsForASeries($series);

    return ($numberOfCompletedLessons / $numberOfLessonsInSeries) * 100;
  }
}
