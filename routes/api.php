<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\ProvincesController;

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


