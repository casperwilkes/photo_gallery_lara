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
Route::get('/test/', 'HomeController@test')->name('test');

// Authentication routes //
Auth::routes();

// Home page //
Route::get('/home', 'HomeController@index')->name('home');

// User dashboard | After login //
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard')->middleware('auth');

// Photograph //
Route::Resource('photographs', 'PhotographsController');

// Comments //
Route::post('comments', 'CommentsController@store')->name('comments.store');
Route::delete('comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');
