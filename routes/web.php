<?php

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

Route::get('/series/{series}', 'FrontendController@series')->name('series');
