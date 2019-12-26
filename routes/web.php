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

Route::get('/threads', 'ThreadController@index')->name('threads.index');
Route::get('/threads/create', 'ThreadController@create')->name('threads.create');
Route::post('/threads', 'ThreadController@store')->name('threads.store');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show')->name('threads.show');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy')->name('threads.delete');

Route::get('/threads/{channel}', 'ThreadController@index')->name('threads.channel');

Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store')->name('replies.store');

Route::delete('/replies/{reply}', 'ReplyController@destroy')->name('replies.delete');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('replies.favorite');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')->name('replies.unfavorite');
Route::patch('/replies/{reply}', 'ReplyController@update')->name('replies.update');


Route::get('/profiles/{user}', 'ProfilesController@show')->name('profiles.show');
