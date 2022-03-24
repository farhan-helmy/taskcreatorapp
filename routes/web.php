<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {


    Route::get('/workspace', [WorkspaceController::class, 'index'])->name('workspace');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('', [DashboardController::class, 'index'])->name('index');
    });

    Route::prefix('workspace')->name('workspace.')->group(function () {
        Route::get('', [WorkspaceController::class, 'index'])->name('index');
        Route::get('create', [WorkspaceController::class, 'create'])->name('create');
        Route::get('data', [WorkspaceController::class, 'data'])->name('data');
        Route::post('store', [WorkspaceController::class, 'store'])->name('store');
        Route::get('/{workspace}', [WorkspaceController::class, 'show'])->name('show');
        Route::get('/{workspace}/tasks', [TaskController::class, 'index'])->name('task.index');
        Route::get('/{workspace}/data', [TaskController::class, 'data'])->name('task.data');
        Route::get('/{workspace}/tasks/create', [TaskController::class, 'create'])->name('task.create');
        Route::get('/{workspace}/tasks/{task}/show', [TaskController::class, 'show'])->name('task.show');
        Route::post('/{workspace}/tasks/{task}/update', [TaskController::class, 'update'])->name('task.update');
        Route::post('/{workspace}/store', [TaskController::class, 'store'])->name('task.store');
    });
});

require __DIR__ . '/auth.php';
