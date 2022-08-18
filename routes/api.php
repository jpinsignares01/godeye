<?php

use App\Http\Controllers\Api\V1\HomeApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
'prefix' => 'v1',
], function () {
    Route::post('planets', [HomeApiController::class, 'getPlanets'])->name('api.get_planets');
    Route::post('person', [HomeApiController::class, 'getPerson'])->name('api.get_person');
});