<?php

use App\Http\Controllers\V1\Task\TaskCreateController;
use App\Http\Controllers\V1\Task\TaskDeleteController;
use App\Http\Controllers\V1\Task\TaskGetController;
use App\Http\Controllers\V1\Task\TaskListController;
use App\Http\Controllers\V1\Task\TaskUpdateController;
use Illuminate\Support\Facades\Route;

Route::post('/', TaskCreateController::class)->name('create');
Route::get('/list', TaskListController::class)->name('list');
Route::put('{taskId}', TaskUpdateController::class)->name('update');
Route::get('{taskId}', TaskGetController::class)->name('getTask');
Route::delete('{taskId}', TaskDeleteController::class)->name('delete');
