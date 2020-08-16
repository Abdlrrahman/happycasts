<?php

// Get Routes

Route::get('/redis', function () {
    return view('series');
});

Auth::routes();

Route::get('/', 'FrontEndController@welcome');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('register/confirm', 'ConfirmEmailController@index')->name('confirm-email');

Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
});

Route::get('/watch-series/{series}', 'WatchSeriesController@index')->name('series.learning');

Route::get('/series/{series}/lesson/{lesson}', 'WatchSeriesController@showLesson')->name('series.watch');

Route::get('/series/{series}', 'FrontendController@series')->name('series');

// Post Routes

Route::post("/series/complete-lesson/{lesson}", 'WatchSeriesController@completeLesson');
