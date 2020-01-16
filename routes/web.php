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
Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('confirm.email');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads', 'ThreadController@index')->name('threads.index');
Route::get('/threads/create', 'ThreadController@create')->name('threads.create');
Route::post('/threads', 'ThreadController@store')->name('threads.store')->middleware('must-be-confirmed');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show')->name('threads.show');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy')->name('threads.delete');
Route::get('/threads/{channel}', 'ThreadController@index')->name('threads.channel');

Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store')->name('replies.store');
Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index')->name('replies.index');
Route::patch('/replies/{reply}', 'ReplyController@update')->name('replies.update');
Route::delete('/replies/{reply}', 'ReplyController@destroy')->name('replies.delete');


Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('replies.favorite');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')->name('replies.unfavorite');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->name('subscribe')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->name('unsubscribe')->middleware('auth');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profiles.show');


Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index')->name('get.notifs');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy')->name('read.notifs');


Route::get('api/users', 'Api\UsersController@index')->name('api.names');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth');
