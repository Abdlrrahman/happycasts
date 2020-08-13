<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/redis', function () {
    //key: value //string
    // Redis::set('friend', 'Alex');
    // dd(Redis::get('friend'));

    //key: value //list
    // Redis::Lpush('farmeworks', ['vue.js', 'laravel']);
    // dd(Redis::Lrange('farmeworks', 0, -1));

    //key: value //set

    // Redis::sadd('front-end-frameworks', ['vue.js', 'angular', 'react.js']);
    // dd(Redis::smembers('front-end-frameworks'));
});

Route::get('/', 'FrontEndController@welcome');

Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
});

Route::get('register/confirm', 'ConfirmEmailController@index')->name('confirm-email');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
