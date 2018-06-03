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

// Index page //
//Route::get('/', function () {
//    //return view('welcome');
//    return view('home/index');
//});

Route::get('/', array('uses' => 'HomeController@index'));
Route::get('/test/{data?}', 'HomeController@test')->name('test');

// Authentication routes //
Auth::routes();

// Home page //
Route::get('/home', 'HomeController@index')->name('home');

// Photograph //
Route::Resource('photographs', 'PhotographsController');

// Comments //
Route::post('comments', 'CommentsController@store')->name('comments.store');
Route::delete('comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');

// User profile | After login //
Route::get('profile/{user?}', 'UsersController@profile')->name('profile');
Route::get('profile/{user}/edit', 'UsersController@edit')->name('profile.edit');
Route::put('profile/{user}', 'UsersController@update')->name('profile.update');