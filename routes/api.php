<?php
header('Access-Control-Allow-Origin: *');

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
  Route::post('/{slug}/ticket-reservation', [\App\Http\Controllers\Api\TicketController::class, 'store']);
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
  Route::get('/', [\App\Http\Controllers\Api\FaqController::class, 'index']);
});

Route::prefix('businesses')->group(function (){
  Route::get('/', [\App\Http\Controllers\Api\BusinessController::class, 'index']);
});

Route::prefix('orders')->group(function (){
  Route::post('create', [\App\Http\Controllers\Api\OrderController::class, 'store']);
  Route::post('capture', [\App\Http\Controllers\Api\OrderController::class, 'capture']);
});

Route::prefix('subscriptions')->group(function (){
    Route::post('/', [\App\Http\Controllers\Api\SubscriptionController::class, 'store']);
});

Route::prefix('statistics')->group(function (){
   Route::post('/', [\App\Http\Controllers\Api\StatisticController::class, 'store']);
});