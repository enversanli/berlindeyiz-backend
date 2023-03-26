<?php

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

Route::prefix('articles')->group(function () {
  Route::get('/', [\App\Http\Controllers\ArticleController::class, 'index']);
  Route::get('/{article}', [\App\Http\Controllers\ArticleController::class, 'show']);
});

Route::prefix('etkinlikler')->group(function (){
  Route::get('/', [\App\Http\Controllers\ServiceController::class, 'index']);
});
