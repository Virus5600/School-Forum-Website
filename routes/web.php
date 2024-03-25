<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['namespace' => "App\Http\Controllers"], function() {
	////////////////
	// GUEST SIDE //
	////////////////

	// TEST
	Route::get('/test', fn() => view('change-password.edit'))->name('test');

	// Home Page
	Route::get('/', 'PageController@index')->name('home');

	// Authentication
	Route::group(['middleware' => ['guest']], function() {
		// Login
		Route::get('/login', 'AuthenticationController@login')->name('login');

		// Authenticate
		Route::post('/login', 'AuthenticationController@authenticate')->name('authenticate');

		// Register
		Route::get('/register', 'AuthenticationController@register')->name('register');
		Route::post('/register', 'AuthenticationController@store')->name('register.store');
	});

	// Announcements
	Route::group(['prefix' => 'announcements'], function() {
		// Index
		Route::get('/', 'AnnouncementController@index')->name('announcements.index');

		// Show
		Route::get('/{slug}', 'AnnouncementController@show')->name('announcements.show');
	});

	// Lost and Found
	Route::group(['prefix' => 'lost-and-found'], function() {
		// Index
		Route::get('/', 'LostFoundController@index')->name('lost-and-found.index');

		// Show
		Route::get('/{id}', 'LostFoundController@show')->name('lost-and-found.show');
	});

	////////////////
	// ADMIN SIDE //
	////////////////
	Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'permissions:admin_access']], function() {
	});
});
