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
}
