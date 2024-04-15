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

	// LoaderIO Verification
	Route::get('loaderio-52abcb913a992fad9c8e1eef99be8e70', 'PageController@loaderIO')->name('loaderio1');
	Route::get('loaderio-d339104e9d20dac006c782f918e6683e', 'PageController@loaderIO')->name('loaderio2');

	// Home Page
	Route::get('/', 'PageController@index')->name('home');

	// Authentication
	Route::group(['middleware' => ['guest']], function() {
		// Login
		Route::get('/login', 'AuthenticationController@login')->name('login');

		// Authenticate
		Route::post('/login', 'AuthenticationController@authenticate')->name('authenticate');

		// Forgot Password
		Route::get('/forgot-password', 'AuthenticationController@forgotPassword')->name('forgot-password');

		// Change Password
		Route::get('/change-password/{token}', 'AuthenticationController@changePassword')->name('change-password.edit');
		Route::post('/change-password/{token}/update', 'AuthenticationController@updatePassword')->name('change-password.update');

		// Register
		Route::get('/register', 'AuthenticationController@register')->name('register');
		Route::post('/register', 'AuthenticationController@store')->name('register.store');
	});

	// Discussions
	Route::group(['prefix' => 'discussions'], function() {
		// Index
		Route::get('/', 'DiscussionController@index')->name('discussions.index');

		// Creating a Discussion
		Route::group(['prefix' => 'create', 'middleware' => ['auth']], function() {
			// Create Page
			Route::get('/', 'DiscussionController@create')->name('discussions.create');

			// Store
			Route::post('/store', 'DiscussionController@store')->name('discussions.store');
		});

		// Categories
		Route::group(['prefix' => 'category'], function() {
			// Index
			Route::get('/', 'DiscussionCategoryController@index')->name('discussions.categories.index');

			// Show (Category)
			Route::group(['prefix' => '{name}'], function() {
				// Show
				Route::get('/', 'DiscussionCategoryController@show')->name('discussions.categories.show');

				// Show (Discussion)
				Route::group(['prefix' => '{slug}'], function() {
					// Show
					Route::get('/', 'DiscussionController@show')->name('discussions.show');

					// Edit
					Route::group(['prefix' => 'edit', 'middleware' => ['auth']], function() {
						// Edit Page
						Route::get('/', 'DiscussionController@edit')->name('discussions.edit');

						// Update
						Route::patch('/update', 'DiscussionController@update')->name('discussions.update');
					});

					// Delete
					Route::delete('/delete', 'DiscussionController@delete')->name('discussions.delete');

					// Comments (AUTHENTICATION REQUIRED)
					Route::group(['prefix' => 'comment', 'middleware' => ['auth']], function() {
						// Store
						Route::post('/store', 'DiscussionRepliesController@store')->name('discussions.comments.store');

						// Comment Modification
						Route::group(['prefix' => '{id}'], function() {
							// Edit
							Route::group(['prefix' => 'edit'], function() {
								// Edit Page
								Route::get('/', 'DiscussionRepliesController@edit')->name('discussions.comments.edit');

								// Update
								Route::patch('/update', 'DiscussionRepliesController@update')->name('discussions.comments.update');
							});

							// Delete
							Route::delete('/delete', 'DiscussionRepliesController@delete')->name('discussions.comments.delete');
						});
					});
				});
			});
		});
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

	//////////////////////////////////
	// SANCTUM/AUTHENTICATED ROUTES //
	//////////////////////////////////
	Route::group(['middleware' => ['auth', 'permissions:sanctum']], function() {
		// Logout
		Route::post('/logout', 'AuthenticationController@logout')->name('logout');

		////////////////////
		// PROFILE MODULE //
		////////////////////
		Route::group(['prefix' => 'profile'], function() {
			// Index
			Route::get('/', 'ProfileController@index')->name('profile.index');

			// Edit
			Route::get('/edit', 'ProfileController@edit')->name('profile.edit');

			// Update
			Route::put('/update', 'ProfileController@update')->name('profile.update');
		});

		/////////////////////////
		// VERIFICATION MODULE //
		/////////////////////////
		Route::group(['prefix' => 'verification', 'middleware' => ['verification:unverified']], function() {
			// Verification Page
			Route::get('/', 'AuthenticationController@verification')->name('verification.index');

			// Verify
			Route::post('verify', 'AuthenticationController@verify')->name('verification.verify');
		});

		////////////////
		// ADMIN SIDE //
		////////////////
		Route::group(['prefix' => 'admin', 'middleware' => ['verification:verified', 'permissions:admin_access']], function() {
			// Dashboard
			Route::get('/', 'PageController@dashboard')->name('admin.dashboard');

			// Lost and Found
			Route::group(['prefix' => 'lost-and-found', 'middleware' => ['permissions:lost_and_found_tab_access']], function() {
				// Index
				Route::get('/', 'LostFoundController@adminIndex')->name('admin.lost-and-found.index');

				// Create
				Route::group(['prefix' => 'create'], function() {
					// Index
					Route::get('/', 'LostFoundController@adminCreate')->name('admin.lost-and-found.create');

					// Store
					Route::post('/store', 'LostFoundController@adminStore')->name('admin.lost-and-found.store');
				});

				// ITEM RELATED //
				Route::group(['prefix' => '{id}'], function() {
					// Show
					Route::get('/', 'LostFoundController@adminShow')->name('admin.lost-and-found.show');

					// Edit
					Route::get('/edit', 'LostFoundController@adminEdit')->name('admin.lost-and-found.edit');

					// Update
					Route::put('/update', 'LostFoundController@adminUpdate')->name('admin.lost-and-found.update');

					// Delete
					Route::delete('/delete', 'LostFoundController@adminDestroy')->name('admin.lost-and-found.destroy');
				});

			});
		});
	});
});
