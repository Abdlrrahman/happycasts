<?php

Auth::routes();

Route::get('/', 'FrontEndController@welcome');

Route::get('register/confirm', 'ConfirmEmailController@index')->name('confirm-email');

Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

Route::get('/series/{series}', 'FrontendController@series')->name('series');

Route::get('/profile/{user}', 'ProfilesController@index')->name('profile');

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
