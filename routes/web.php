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
Route::get('/series/{series}', 'FrontEndController@series')->name('series');

// get a user's profile
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile');

// get all the series
Route::get('/series', 'FrontEndController@showAllseries')->name('all-series');

// authanticated user routes
Route::middleware('auth')->group(function () {
    // update user route
    Route::patch('/profile/{user}/update', ['as' => 'users.update', 'uses' => 'ProfilesController@updateUser']);
    // complete a lesson post route
    Route::post('/series/complete-lesson/{lesson}', 'WatchSeriesController@completeLesson');
    // create a subscription route
    Route::post('/subscribe', 'SubscriptionsController@subscribe');
    // change the subscription route
    Route::post('/subscription/change', 'SubscriptionsController@change')->name('subscriptions.change');
    // update a card route
    Route::post('/card/update', 'ProfilesController@updateCard');
    //show subscription form route
    Route::get('/subscribe', 'SubscriptionsController@showSubscriptionForm');
    //get the watch page route
    Route::get('/watch-series/{series}', 'WatchSeriesController@index')->name('series.learning');
    //show a lesson page route
    Route::get('/series/{series}/lesson/{lesson}', 'WatchSeriesController@showLesson')->name('series.watch');
});
