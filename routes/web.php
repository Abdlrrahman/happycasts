<?php

// authanticate the routes
Auth::routes();

// get the welcome page
Route::get('/', 'FrontEndController@welcome');

// get the confirm email page
Route::get('register/confirm', 'ConfirmEmailController@index')->name('confirm-email');

// logout and redirect to the welcome page
Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// get a series
Route::get('/series/{series}', 'FrontendController@series')->name('series');

// get a user's profile
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile');

// get all the series
Route::get('/series', 'FrontendController@showAllseries')->name('all-series');


Route::middleware('auth')->group(function () {
    Route::post('/series/complete-lesson/{lesson}', 'WatchSeriesController@completeLesson');
    Route::post('/subscribe', 'SubscriptionsController@subscribe');
    Route::post('/subscription/change', 'SubscriptionsController@change')->name('subscriptions.change');
    Route::post('/card/update', 'ProfilesController@updateCard');
    Route::get('/subscribe', 'SubscriptionsController@showSubscriptionForm');
    Route::get('/watch-series/{series}', 'WatchSeriesController@index')->name('series.learning');
    Route::get('/series/{series}/lesson/{lesson}', 'WatchSeriesController@showLesson')->name('series.watch');
});
