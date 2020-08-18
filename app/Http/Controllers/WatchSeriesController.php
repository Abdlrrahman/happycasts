<?php

namespace HappyCasts\Http\Controllers;

use HappyCasts\Series;
use HappyCasts\Lesson;

class WatchSeriesController extends Controller
{
    public function index(Series $series)
    {
        $user = auth()->user();

        if ($user->hasStartedSeries($series)) {
            return redirect()->route('series.watch', [
                'series' => $series->slug,
                'lesson' => $user->getNextLessonToWatch($series)
            ]);
        }

        return redirect()->route('series.watch', [
            'series' => $series->slug,
            'lesson' => $series->lessons->first()->id
        ]);
    }

    public function showLesson(Series $series, Lesson $lesson)
    {
        if ($lesson->premium && !auth()->user()->subscribed('monthly') && !auth()->user()->subscribed('yearly')) {
            return redirect('subscribe');
        }

        return view('watch', [
            'series' => $series,
            'lesson' => $lesson
        ]);
    }

    public function completeLesson(Lesson $lesson)
    {
        auth()->user()->completeLesson($lesson);
        return response()->json([
            'status' => 'ok'
        ]);
    }
}
