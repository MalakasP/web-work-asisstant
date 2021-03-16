<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['as' => 'api.'], function () {

    Route::post('login', 'LoginController@login')->name('login');

    Route::post('register', 'RegisterController@register')->name('register');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::get('email/verify/{hash}', 'VerificationController@verify')->name('verification.verify');

        Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');

        Route::get('user', 'AuthenticationController@user')->name('user');

        Route::post('logout', 'LoginController@logout')->name('logout');

        Route::resource('tasks', 'TaskController', ['except' => ['create', 'edit']]);

        Route::resource('projects', 'ProjectController', ['except' => ['create', 'edit']]);

        Route::resource('worktimes', 'WorktimeController', ['except' => ['create', 'edit']]);

        Route::resource('requests', 'RequestController', ['except' => ['create', 'edit']]);

        Route::resource('teams', 'TeamController', ['except' => ['create', 'edit']]);

        Route::post('teams/{team}/users/{user}', 'AdminController@store')->name('admin.addTeamUser');
        // Route::put('teams/{team}', 'TeamController@update');
    });
});