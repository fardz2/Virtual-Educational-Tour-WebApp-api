<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Article\ArticleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get("article", [ArticleController::class, 'index']);
Route::get("article/{slug}", [ArticleController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post("article", [ArticleController::class, 'store']);
    Route::get("info", [AuthController::class, 'getInfo']);
    Route::put("edit-info", [AuthController::class, 'editInfo']);
});
