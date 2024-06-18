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
    Route::get('show/{id}', [WebsiteController::class, 'view']);
    Route::delete('delete/{id}', [WebsiteController::class, 'delete'])->middleware('admin');
    Route::post('vote{website_id}', [UtilityController::class, 'vote']);
    Route::post('unvote{website_id}', [UtilityController::class, 'unvote']);
});
