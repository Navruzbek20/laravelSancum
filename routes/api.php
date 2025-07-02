<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LocusController;
use App\Http\Controllers\PopulationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware("auth:sanctum")->group(function () {
    Route::get('user', [UserController::class, 'user']);
    Route::post('image', [ImageController::class, 'createImage']);

    Route::post('population', [PopulationController::class, 'createPopulation']);
    Route::put('population/{id}', [PopulationController::class, 'updatePopulation']);
    Route::get('population', [PopulationController::class, 'getPopulation']);
    Route::delete('population/{id}', [PopulationController::class, 'deletePopulation']);
    Route::post('population/{id}', [PopulationController::class, 'getPopulationById']);
    Route::posst('population/active/{id}', [PopulationController::class, 'setActive']);

    Route::post('locus',[LocusController::class, 'createLocus']);
    Route::put('locus/{id}',[LocusController::class, 'updateLocus']);
    Route::get('locus', [LocusController::class, 'getLocus']);
    Route::delete('locus/{id}', [LocusController::class, 'deleteLocus']);
    Route::post('locus/{id}', [LocusController::class, 'getLocusById']);
    Route::post('locus/active/{id}', [LocusController::class, 'setActive']);

    Route::post('group',[GroupController::class, 'createGroup']);
    Route::put('group/{id}',[GroupController::class, 'updateGroup']);
    Route::get('group', [GroupController::class, 'getGroup']);
    Route::delete('group/{id}', [GroupController::class, 'deleteGroup']);
    Route::post('group/{id}', [GroupController::class, 'getGroupById']);
    Route::post('group/active/{id}', [GroupController::class, 'setActive']);


});

Route::post('register', [UserController::class, 'register']);
Route::get('login', [UserController::class, 'login']);


