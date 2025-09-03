<?php

use App\Http\Controllers\CodeController;
use App\Http\Controllers\FrequencyController;
use App\Http\Controllers\GenomItemController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LocusController;
use App\Http\Controllers\LocusGroupController;
use App\Http\Controllers\PopulationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\Code;
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
    Route::get('users', [UserController::class, 'user']);
    Route::put('users/{id}',[UserController::class,'update']);
    Route::delete('users/{id}',[UserController::class,'destroy']);
    Route::put('users/active/{id}', [UserController::class, 'setActive']);
    Route::post('image', [ImageController::class, 'createImage']);

    Route::post('populations', [PopulationController::class, 'createPopulation']);
    Route::put('populations/{id}', [PopulationController::class, 'updatePopulation']);
    Route::get('populations', [PopulationController::class, 'getPopulation']);
    Route::delete('populations/{id}', [PopulationController::class, 'deletePopulation']);
    Route::post('populations/{id}', [PopulationController::class, 'getPopulationById']);
    Route::put('populations/active/{id}', [PopulationController::class, 'setActive']);

    Route::post('locus',[LocusController::class, 'createLocus']);
    Route::put('locus/{id}',[LocusController::class, 'updateLocus']);
    Route::get('locus', [LocusController::class, 'getLocus']);
    Route::delete('locus/{id}', [LocusController::class, 'deleteLocus']);
    Route::post('locus/{id}', [LocusController::class, 'getLocusById']);
    Route::put('locus/active/{id}', [LocusController::class, 'setActive']);

    Route::post('groups',[GroupController::class, 'createGroup']);
    Route::put('groups/{id}',[GroupController::class, 'updateGroup']);
    Route::get('groups', [GroupController::class, 'getGroup']);
    Route::delete('groups/{id}', [GroupController::class, 'deleteGroup']);
    Route::post('groups/{id}', [GroupController::class, 'getGroupById']);
    Route::put('groups/active/{id}', [GroupController::class, 'setActive']);

    Route::post('locus_group', [LocusGroupController::class, 'create']);
    Route::get('locus_group', [LocusGroupController::class, 'getLocusGroup']);
    Route::get('locus_group/locus/{id}', [LocusGroupController::class, 'getLocusGroupByLocus']);
    Route::get('locus_group/group/{id}', [LocusGroupController::class, 'getLocusGroupByGroup']);
    Route::put('locus_group/{id}', [LocusGroupController::class, 'undate']);
    Route::delete('locus_group/{id}', [LocusGroupController::class, 'delete']);

    Route::post('frequency',[FrequencyController::class, 'create']);
    Route::get('frequency', [FrequencyController::class, 'index']);
    Route::get('frequency/{id}', [FrequencyController::class, 'show']);
    Route::put('frequency/{id}', [FrequencyController::class, 'update']);
    Route::delete('frequency/{id}', [FrequencyController::class, 'delete']);

    Route::post('code',[CodeController::class, 'create']);
    Route::delete('code/{id}', [CodeController::class, 'delete']);
    Route::get('code', [CodeController::class, 'index']);
    Route::get('code/{id}', [CodeController::class, 'show']);

    Route::post('genom_item',[GenomItemController::class,'storeFullGenomData']);
    Route::post('genom_item_doc',[GenomItemController::class,'storeFullGenomDocument']);

});

Route::post('users', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


