<?php

namespace HappyCasts\Http\Controllers;

use HappyCasts\Series;
use HappyCasts\Lesson;

class WatchSeriesController extends Controller
{
    public function index(Series $series)
    {
        return redirect()->route('series.watch', [
            'series' => $series->slug,
            'lesson' => $series->lessons->first()->id
        ]);
    }

    public function showLesson(Series $series, Lesson $lesson)
    {
        return view('watch', [
            'series' => $series,
            'lesson' => $lesson
        ]);
    }
}
