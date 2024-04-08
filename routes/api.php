<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => "App\Http\Controllers", 'middleware' => ['permissions:sanctum']], function() {
	// Resend Verification
	Route::post('/resend', 'AuthenticationController@resendVerification')->name('verification.resend');

	// Discussion Related
	Route::group(['prefix' => 'discussions'], function() {
		// Upvote (Discussion)
		Route::patch('/upvote', 'DiscussionController@upvote')->name('api.discussions.upvote');

		// Downvote (Discussion)
		Route::patch('/downvote', 'DiscussionController@downvote')->name('api.discussions.downvote');
	});
});
