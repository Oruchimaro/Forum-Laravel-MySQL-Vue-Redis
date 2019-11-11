<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/threads', 'ThreadController@index')->name('threads.index');
// Route::get('/threads/create', 'ThreadController@create')->name('threads.create');
// Route::post('/threads', 'ThreadController@store')->name('threads.store');
// Route::get('/threads/{thread}', 'ThreadController@show')->name('threads.show');
Route::resource('threads', 'ThreadController');
Route::post('/threads/{thread}/replies', 'ReplyController@store')->name('replies.store');

