<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceQuestionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ValidatorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::get('sitemap', function () {
  include('../sitemap.xml');
});

Route::view('/impressum', 'web.others.impressum');

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('csrf', function () {
  return csrf_token();
});

Route::prefix('admin')->middleware('auth')->group(function () {

  Route::get('/dashboard', function () {
    return view('dashboard');
  })->name('dashboard');


  /** Users */
  Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.list');
    Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
    Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
    Route::get('/{id}/delete', [UserController::class, 'destroy'])->name('user.destroy');
  });
  /** end Users */


  Route::resource('/faq', \App\Http\Controllers\Admin\FaqController::class)
    ->only('index', 'show', 'store', 'create')
    ->name('index', 'faq.index')
    ->name('show', 'faq.show')
    ->name('store', 'faq.store')
    ->name('create', 'faq.create');

  Route::prefix('faq')->group(function () {
    Route::post('/{id}', [\App\Http\Controllers\Admin\FaqController::class, 'update'])->name('faq.update');
    Route::get('/{id}/destroy', [\App\Http\Controllers\Admin\FaqController::class, 'destroy'])->name('faq.destroy');
  });

  Route::resource('announcements', AnnouncementController::class)
    ->name('store', 'announcement.store')
    ->name('index', 'announcement.index')
    ->name('create', 'announcement.create')
    ->name('show', 'announcement.show');

  Route::post('/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');
  Route::get('/announcements/{id}/destroy', [AnnouncementController::class, 'destroy'])->name('announcement.destroy');

  /** Sliders */
  Route::resource('sliders', SliderController::class)
    ->name('index', 'slider.index')
    ->name('store', 'slider.store');

  Route::get('/{id}/destroy', [SliderController::class, 'destroy'])->name('slider.destroy');
  /** end Sliders */

  /** Services */
  Route::get('service-types', [ServiceController::class, 'types'])->name('service.types');
  Route::get('service-categories/{id}', [ServiceController::class, 'categories'])->name('service.categories');
  Route::resource('services', ServiceController::class)
    ->only('index', 'show', 'store', 'create')
    ->name('index', 'service.index')
    ->name('create', 'service.create')
    ->name('store', 'service.store')
    ->name('show', 'service.show');

  Route::post('/{service}', [ServiceController::class, 'update'])->name('service.update');
  Route::get('/{service}/delete', [ServiceController::class, 'destroy'])->name('service.destroy');

  /** end Services */

  /** Questions */
  Route::get('/services/{service_id}/questions', [ServiceQuestionController::class, 'index'])->name('service.questions');
  Route::get('/services/{service_id}/question/{id}', [ServiceQuestionController::class, 'show'])->name('service-question.show');
  Route::get('/services/{service_id}/question', [ServiceQuestionController::class, 'create'])->name('service-question.create');
  Route::post('/services/{service_id}/question', [ServiceQuestionController::class, 'store'])->name('service-question.store');
  Route::post('/services/{service_id}/question/{id}', [ServiceQuestionController::class, 'update'])->name('service-question.update');
  Route::get('/services/{service_id}/question/{id}/destroy', [ServiceQuestionController::class, 'destroy'])->name('service-question.destroy');
  /** end Questions */

  /** Profile */
  Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('profile');
    Route::post('/', [ProfileController::class, 'update'])->name('profile.update');
  });
  /** end Profile */

  /** Business */
  Route::prefix('/businesses')->group(function () {
    Route::get('', [\App\Http\Controllers\Admin\BusinessController::class, 'index']);
    Route::get('/{business}', [\App\Http\Controllers\Admin\BusinessController::class, 'show']);
  });
  /** end Business */

});

Route::prefix('/')->middleware('web')->group(function () {

  /** WEB START */
  Route::view('deprem-yardimlasma-bilgilendirme', '');

  Route::get('', [\App\Http\Controllers\ServiceController::class, '__invoke']);
  Route::get('/doktorlar', [\App\Http\Controllers\ServiceController::class, '__invoke']);
  Route::get('/avukatlar', [\App\Http\Controllers\ServiceController::class, '__invoke']);
  Route::get('hizmet-ara', [\App\Http\Controllers\ServiceController::class, '__invoke']);

  Route::redirect('turk-doktorlari', 'doktorlar?type=doktorlar&category=turk-doktorlari', 301);
  Route::redirect('turk-avukatlari', 'avukatlar?type=avukatlar&category=turk-avukatlari', 301);


  /** Categories */
  Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
  Route::get('/service-types', [\App\Http\Controllers\CategoryController::class, 'serviceTypes']);
  /** end Categories */

  Route::get('sikca-sorulan-sorular', [FaqController::class, 'index'])->name('public-faq.list');
  Route::get('duyurular', [\App\Http\Controllers\AnnouncementController::class, 'index'])->name('public-announcements.list');
  Route::get('sliders', [\App\Http\Controllers\SliderController::class, 'index'])->name('public-sliders.list');

  /** Services */
  Route::get('etkinlikler', [\App\Http\Controllers\ServiceController::class, 'index'])->name('front.services');

  Route::get('etkinlikler/son-eklenenler', [\App\Http\Controllers\ServiceController::class, 'lastAdded'])->name('front.services.last-added');

  Route::get('sehir-etkinlikleri/{slug}/{count?}', [\App\Http\Controllers\ServiceController::class, 'getCityServices']);
  Route::post('hizmet-ara', [\App\Http\Controllers\ServiceController::class, 'index'])->name('front.service-search-detail');
  Route::get('etkinlikler/{slug}', [\App\Http\Controllers\ServiceController::class, 'show']);
  Route::get('etkinlikler/{slug}/ticket', [\App\Http\Controllers\ServiceController::class, 'ticketCreate']);
  Route::post('etkinlikler/{slug}/ticket', [\App\Http\Controllers\TicketController::class, 'store']);
  Route::get('doktorlar/{slug}', [\App\Http\Controllers\ServiceController::class, 'show']);
  Route::get('avukatlar/{slug}', [\App\Http\Controllers\ServiceController::class, 'show']);
  /** end Services */

  Route::view('/cerez-politikasi', 'web.info.cookie');

  Route::get('/search/{word}', [\App\Http\Controllers\ServiceController::class, 'search']);
  Route::get('/{slug}', [\App\Http\Controllers\ServiceController::class, 'show']);
  Route::get('/service/{id}/guide', [\App\Http\Controllers\ServiceController::class, 'guide']);
  Route::get('/{id}/questions', [\App\Http\Controllers\ServiceController::class, 'guide']);
//Route::get('/{id}/questions/{id}', [ServiceController::class, 'guide']);


  /** end WEB START */

});