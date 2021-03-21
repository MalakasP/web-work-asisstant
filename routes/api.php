<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
// use App\Http\Controllers\Api\TaskController;
// use App\Http\Controllers\Api\ProjectController;
// use App\Http\Controllers\Api\WorktimeController;
// use App\Http\Controllers\Api\RequestController;
// use App\Http\Controllers\Api\TeamController;


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

    Route::post('login', [LoginController::class, 'login'])->name('login');

    Route::post('register', [RegisterController::class, 'register'])->name('register');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        //do I need this?
        // Route::get('email/verify/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

        // Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

        // Route::get('user', [AuthenticationController::class, 'user'])->name('user');

        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::resource('tasks', TaskController::class, ['except' => ['create', 'edit']]);

        Route::resource('projects', ProjectController::class, ['except' => ['create', 'edit']]);

        Route::resource('worktimes', WorktimeController::class, ['except' => ['create', 'edit']]);

        Route::resource('requests', RequestController::class, ['except' => ['create', 'edit']]);

        Route::resource('teams', TeamController::class, ['except' => ['create', 'edit']]);

        Route::post('teams/{team}/users/{user}', [AdminController::class, 'store'])->name('admin.addTeamUser');

        // Route::put('teams/{team}', 'TeamController@update');
    });
});