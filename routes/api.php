<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\ProvincesController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserinformationController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });






Route::get('/provinces',[ProvincesController::class,'index']);
Route::get('/provinces/{id}',[ProvincesController::class,'show']);



Route::controller(RegionController::class)->group(function(){
    Route::get('/regions','index');
    Route::get('/regions/{id}','show');
    Route::post('/regions/store','store');
    Route::post('/regions/update/{id}','update');
    Route::post('/regions/delete/{id}','delete');
});


Route::controller(UserinformationController::class)->group(function(){
    Route::get('/usersinfo','index');
    Route::get('/userinfo/{id}','show');
    Route::post('/userinfo/store','store');
    Route::post('/userinfo/update/{id}','update');
    Route::post('/userinfo/delete/{id}','delete');
});


Route::get('/transactions',[TransactionController::class,'index']);
