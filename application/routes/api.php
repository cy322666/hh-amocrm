<?php

use App\Http\Controllers\HHController;
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

Route::post('hh/1/hook', [HHController::class, 'hook1']);

Route::post('hh/2/hook', [HHController::class, 'hook2']);

Route::any('hh/redirect', [HHController::class, 'redirect']);
