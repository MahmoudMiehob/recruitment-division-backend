<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\AcceptController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\ProvincesController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\QuestionAnswerController;
use App\Http\Controllers\Api\UserinformationController;
use App\Http\Controllers\Api\TransactionArchiveController;

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






Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    

});


Route::group(['middleware' => 'jwt.verify'],function(){


    Route::get('/home',[HomeController::class,'__invoke']);


    Route::controller(ProvincesController::class)->group(function(){
        Route::get('/provinces','index');
        Route::get('/provinces/{id}','show');
    });


    Route::controller(RegionController::class)->group(function(){
        Route::get('/regions','index');
        Route::get('/regions/{id}','show');
        Route::get('/regions/{id}/transaction','getAllRegionTransactions');
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



    Route::controller(TransactionController::class)->group(function(){
        Route::get('/transactions','index');
        Route::get('/transaction/{id}','show');
        Route::get('/transaction/showalltransaction/{id}','showalltransaction');//
        Route::post('/transaction/store','store');
        Route::post('/transaction/update/{id}','update');
        Route::post('/transaction/delete/{id}','delete');
    });


    Route::controller(TransactionArchiveController::class)->group(function(){
        Route::get('/transactionsarchive','index');
        Route::get('/transactionsarchive/{id}','show');
        Route::post('/transactionsarchive/restore/{id}','restore');
        Route::post('/transactionsarchive/delete/{id}','delete');
    });



    Route::controller(QuestionAnswerController::class)->group(function(){
        Route::get('/question_and_answer','index');
        Route::post('/question_and_answer/store','store');
        Route::post('/question_and_answer/update/{id}','update');
        Route::post('/question_and_answer/delete/{id}','delete');
    });



    Route::controller(AcceptController::class)->group(function(){
        Route::post('/transactions/acceptregion/{id}','acceptregion');
        Route::post('/transactions/rejectregion/{id}','rejectregion');
        Route::post('/transactions/acceptprovince/{id}','acceptprovince');
        Route::post('/transactions/rejectprovince/{id}','rejectprovince');
    });

});