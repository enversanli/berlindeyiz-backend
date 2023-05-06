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

Route::prefix('activities')->group(function (){
  Route::get('/', [\App\Http\Controllers\Api\ServiceController::class, 'index']);
  Route::get('/son-eklenenler', [\App\Http\Controllers\Api\ServiceController::class, 'lastAdded']);
  Route::get('/search/{word}', [\App\Http\Controllers\Api\ServiceController::class, 'search']);
  Route::get('/{slug}', [\App\Http\Controllers\Api\ServiceController::class, 'show']);
  Route::get('/{slug}/ticket-reservation', [\App\Http\Controllers\Api\ServiceController::class, 'ticketCreate']);
});

Route::get('sliders', [\App\Http\Controllers\Api\SliderController::class, 'index']);

Route::prefix('articles')->group(function () {
  Route::get('/', [\App\Http\Controllers\ArticleController::class, 'index']);
  Route::get('/{article}', [\App\Http\Controllers\ArticleController::class, 'show']);
});

Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
Route::get('/service-types', [\App\Http\Controllers\CategoryController::class, 'serviceTypes']);

Route::prefix('announcements')->group(function (){
  Route::get('/', [\App\Http\Controllers\Api\AnnouncementController::class, 'index']);
});

Route::prefix('faqs')->group(function (){
  Route::get('/', [\App\Http\Controllers\Api\AnnouncementController::class, 'index']);
});
