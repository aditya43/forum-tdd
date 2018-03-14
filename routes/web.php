<?php

Route::get('/', 'ThreadsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::resource('threads', 'ThreadsController');
Route::get('threads', 'ThreadsController@index');
Route::get('threads/create', 'ThreadsController@create');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');

Route::get('threads/{channel}', 'ThreadsController@index');

Route::post('/threads', 'ThreadsController@store');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy');

Route::post('/replies/{reply}/favourites', 'FavouritesController@store');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
