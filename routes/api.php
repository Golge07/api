<?php

use App\Http\Controllers\ShelfController;
use App\Http\Controllers\UsersController;
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
Route::controller(ShelfController::class)->group(function(){
    Route::get("/shelf","index");
    Route::get("/shelf/{id}","show");
    Route::post("/shelf/","store");
    Route::put("/shelf/{id}","update");
    Route::delete("/shelf/{id}","destroy");
});
Route::controller(UsersController::class)->group(function(){
    Route::get("/user","index");
    Route::get("/user/{id}","show");
    Route::post("/user/","store");
    Route::put("/user/{id}","update");
    Route::delete("/user/{id}","destroy");
    Route::post("/user/check/","checkUser");
});