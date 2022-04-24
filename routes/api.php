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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('subscribers', 'SubscriberController');
Route::get('subscribers/search/{searchBy}/{query}', 'SubscriberController@search');
Route::apiResource('states', 'StateController');
Route::apiResource('subscriber/{subscriber}/fields', 'FieldController');
