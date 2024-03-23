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

	// Home Page
	Route::get('/', 'PageController@index')->name('home');

	// Announcements
	Route::group(['prefix' => 'announcements'], function() {
		// Index
		Route::get('/', 'AnnouncementController@index')->name('announcements');

		// Show
		Route::get('/{slug}', 'AnnouncementController@show')->name('announcements.show');
	});
});
