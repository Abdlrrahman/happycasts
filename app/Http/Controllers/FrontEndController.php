<?php

namespace HappyCasts\Http\Controllers;

use Illuminate\Http\Request;
use HappyCasts\Series;

class FrontEndController extends Controller
{
    public function welcome()
    {
        return view('welcome')->withSeries(Series::all());
    }

    public function series(Series $series)
    {
        return view('series')->withSeries($series);
    }

    public function showAllSeries()
    {
        return view('all-series')->withSeries(Series::all());
    }
}
