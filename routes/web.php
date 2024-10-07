<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManageTaskController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware('auth:web')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update/{id}', [UserController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/profile/password/update/{id}', [UserController::class, 'passwordUpdate'])->name('profile.password.update');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::resource('/manage-tasks', ManageTaskController::class);
        Route::get('/admin/tasks/live', [ManageTaskController::class, 'getLiveTasks'])->name('manage-tasks.live');
        Route::post('/manage-task/status/update/{id}', [ManageTaskController::class, 'updateStatus'])->name('manage-task.update.status');
        Route::resource('/manage-users', ManageUserController::class);
    });
    
    
    Route::middleware('user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
        Route::resource('/tasks', TaskController::class);
        Route::post('/tasks/status/update/{id}', [TaskController::class, 'updateStatus'])->name('task.update.status');
        Route::get('/user/tasks/live', [TaskController::class, 'getLiveTasks'])->name('tasks.live');
    });
});
