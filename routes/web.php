<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index' )->name('home');

Auth::routes();

//Route::resource('/profile/{username}', 'PhotoController');
Route::get('/p/create', 'PostController@create', 'post.show'); // url 'http://... /p/create' executes 'function create()', in PostController.php
Route::post('/p/store', 'PostController@store'); // url 'http://... /p/create' executes 'function create()', in PostController.php
Route::get('/p/{post}', 'PostController@show');

Route::get('/profile/{username}', 'ProfilesController@index')->name('profile.show');

// this doesnt work: returns 404
Route::get('/profile/edit', function() { 
        dd('ads'); 
} );

// TODO: it doesn work if I use /profile/edit. It works with /profile/{username}/eduit
Route::get('/edit-profile', 'ProfilesController@edit')->name('profile.edit'); // the form
Route::patch('/update-profile', 'ProfilesController@update')->name('profile.update'); // the post data management

//AJAX
// Route::get('ajaxRequest', 'HomeController@ajaxRequest');
Route::post('ajaxRequestFollowPost', 'ProfilesController@ajaxRequestFollow');