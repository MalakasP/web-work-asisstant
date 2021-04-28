<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskStatusController;
use App\Http\Controllers\Api\TaskPriorityController;
use App\Http\Controllers\Api\RequestController;


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

    /**
     * Login controller login route
     */
    Route::post('login', [LoginController::class, 'login'])->name('login');

    /**
     * Register controller register route
     */
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        /**
         * Login controller logout route
         */
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        /**
         * User controller routes
         */
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

        Route::get('users', [UserController::class, 'index'])->name('users.index');

        /**
         * Task status controller route
         */
        Route::get('taskStatuses', [TaskStatusController::class, 'index'])->name('taskStatuses.index');

        /**
         * Task priorities controller route
         */
        Route::get('taskPriorities', [TaskPriorityController::class, 'index'])->name('taskPriorities.index');

        /**
         * Task controller routes
         */
        Route::get('assignedTasks', [TaskController::class, 'getAssignedTasks'])->name('getAssignedTasks');

        Route::get('createdTasks', [TaskController::class, 'getCreatedTasks'])->name('getCreatedTasks');

        Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

        Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');

        Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

        Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

        /**
         * Project controller routes
         */
        Route::get('users/{user}/projects', [ProjectController::class, 'getUserProjects'])->name('getUserProjects');

        Route::get('users/{user}/teamProjects', [ProjectController::class, 'getCreatedAndTeamProjects'])->name('getCreatedAndTeamProjects');

        Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

        Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');

        Route::put('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');

        Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

        /**
         * Worktimes resource controller routes
         */
        Route::resource('worktimes', WorktimeController::class, ['except' => ['create', 'edit']]);

        /**
         * Request controller routes
         */
        Route::get('createdRequests', [RequestController::class, 'getCreatedRequests'])->name('getCreatedRequests');

        Route::get('getNotAnsweredRequests', [RequestController::class, 'getNotAnsweredRequests'])->name('getNotAnsweredRequests');

        Route::get('getAnsweredRequests', [RequestController::class, 'getAnsweredRequests'])->name('getAnsweredRequests');

        Route::get('requests/{request}', [RequestController::class, 'show'])->name('requests.show');

        Route::post('requests', [RequestController::class, 'store'])->name('requests.store');

        Route::put('requests/{request}', [RequestController::class, 'update'])->name('requests.update');

        Route::delete('requests/{request}', [RequestController::class, 'destroy'])->name('requests.destroy');

        /**
         * Team resource controller routes
         */
        Route::resource('teams', TeamController::class, ['except' => ['create', 'edit']]);

        /**
         * Admin controller routes
         */
        Route::post('teams/{team}/addUser', [AdminController::class, 'store'])->name('admin.addTeamUser');

        Route::put('teams/{team}/users/{user}', [AdminController::class, 'update'])->name('admin.update');

        Route::delete('teams/{team}/users/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');

        Route::get('teams/{team}/worktimes', [AdminController::class, 'getTeamUsersWorktimes'])->name('admin.getTeamUsersWorktimes');

        Route::get('project/{project}/tasks', [AdminController::class, 'getProjectTaskByStatus'])->name('admin.getProjectTaskByStatus');

    });
});