<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProblemsController;

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

///////////////////////////////////// Part 1 ///////////////////////////////////////////
///////////////////////////////////// Problem 1
Route::get('/first_problem/{left}/{right}',[ProblemsController::class,'allNumbersBut5']);

/////////////////////////////////////

///////////////////////////////////// Problem 2
Route::get('/second_problem/{input}',[ProblemsController::class,'getStringIndex']);
//////////////////////////////////////////////////////////////////////////

///////////////////////////////////// Problem 3
Route::post('/third_problem',[ProblemsController::class,'stepsToZero']);
//////////////////////////////////////////////////////////////////////////





///////////////////////////////////// Part 2 ///////////////////////////////////////////
Route::post('/login',[UserController::class,'login']);
Route::post('/register',[UserController::class,'register']);
Route::get('/get_users',[UserController::class,'getAllUsers']);
Route::get('/get_user/{id}',[UserController::class,'getUser']);
Route::delete('/delete_user/{id}',[UserController::class,'deleteUser']);
Route::put('/update_user/{id}',[UserController::class,'updateUser']);
///////////////////////////////////////////////////////////////////////////////////////



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
