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

Route::prefix('v1')->as('v1:')->middleware(['throttle:api'])->group(function () {
    Route::prefix('task')->as('task:')->middleware('auth:sanctum')->group(base_path(
        path: 'routes/api/v1/task.php'
    ));

    Route::prefix('user')->as('user:')->group(base_path(
        path: 'routes/api/v1/user.php'
    ));
});
