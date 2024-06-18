<?php

use App\Http\Controllers\AuthenticantionController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|guest can  view listings  search and  filter
*/
Route::get('list', [UtilityController::class, 'listing']);
Route::post('login', [AuthenticantionController::class, 'login']);
Route::get('logout', [AuthenticantionController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('create', [WebsiteController::class, 'create']);
    Route::get('website', [WebsiteController::class, 'view']);
    Route::post('website/delete', [WebsiteController::class, 'delete'])->middleware('admin');
    Route::post('vote', [UtilityController::class, 'vote']);
    Route::post('unvote', [UtilityController::class, 'unvote']);
});
