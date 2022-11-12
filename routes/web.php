<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('sitemap', function (){

  include('../sitemap.xml');
});

Route::view('/impressum', 'web.others.impressum');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

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
    Route::prefix('users')->group(function (){
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user.list');
        Route::get('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.user.show');
        Route::put('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.user.update');
        Route::get('/{id}/delete', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.user.destroy');
    });
    /** end Users */

    /** Services */
    Route::prefix('services')->group(function (){
        Route::get('/', [\App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('admin.service.list');
        Route::get('/create', [\App\Http\Controllers\Admin\ServiceController::class, 'create'])->name('admin.service.create');
        Route::get('/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'show'])->name('admin.service.show');
        Route::put('/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'update'])->name('admin.service.update');
        Route::get('/{service}/delete', [\App\Http\Controllers\Admin\ServiceController::class, 'show'])->name('admin.service.destroy');
    });
    /** end Services */


    Route::prefix('faq')->group(function () {
        Route::get('/list', [\App\Http\Controllers\Admin\FaqController::class, 'index'])->name('faq');
        Route::get('/{id}', [\App\Http\Controllers\Admin\FaqController::class, 'show'])->name('faq.show');
        Route::get('/', [\App\Http\Controllers\Admin\FaqController::class, 'create'])->name('faq.create');
        Route::post('/', [\App\Http\Controllers\Admin\FaqController::class, 'store'])->name('faq.store');
        Route::post('/{id}', [\App\Http\Controllers\Admin\FaqController::class, 'update'])->name('faq.update');
        Route::get('/{id}/destroy', [\App\Http\Controllers\Admin\FaqController::class, 'destroy'])->name('faq.destroy');
    });

    Route::prefix('announcements')->group(function () {
        Route::get('', [\App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('announcement.list');
        Route::get('/create', [\App\Http\Controllers\Admin\AnnouncementController::class, 'create'])->name('announcement.create');
        Route::get('{id}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'show'])->name('announcement.show');
        Route::post('/', [\App\Http\Controllers\Admin\AnnouncementController::class, 'store'])->name('announcement.store');
        Route::post('/{id}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'update'])->name('announcement.update');
        Route::get('/{id}/destroy', [\App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])->name('announcement.destroy');
    });

    Route::prefix('validators')->group(function () {
        Route::get('', [\App\Http\Controllers\Admin\ValidatorController::class, 'index'])->name('validator.list');
        Route::get('/create', [\App\Http\Controllers\Admin\ValidatorController::class, 'create'])->name('validator.create');
        Route::get('{id}', [\App\Http\Controllers\Admin\ValidatorController::class, 'show'])->name('validator.show');
        Route::post('/', [\App\Http\Controllers\Admin\ValidatorController::class, 'store'])->name('validator.store');
        Route::post('/{id}', [\App\Http\Controllers\Admin\ValidatorController::class, 'update'])->name('validator.update');
        Route::get('/{id}/destroy', [\App\Http\Controllers\Admin\ValidatorController::class, 'destroy'])->name('validator.destroy');
    });

    Route::prefix('sliders')->group(function () {
        Route::get('', [\App\Http\Controllers\Admin\SliderController::class, 'index'])->name('slider.list');
        Route::post('', [\App\Http\Controllers\Admin\SliderController::class, 'store'])->name('slider.store');
        Route::get('/{id}/destroy', [\App\Http\Controllers\Admin\SliderController::class, 'destroy'])->name('slider.destroy');
    });
});

Route::prefix('organizer')->middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    /** Profile */
    Route::prefix('profile')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile');
        Route::post('/', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    });
    /** end Profile */

    /** Business */
    Route::prefix('/business')->group(function () {
        Route::get('', [\App\Http\Controllers\Organizer\BusinessController::class, 'index']);
    });
    /** end Business */

    /** Services */
    Route::prefix('/services')->group(function () {
        Route::get('/guide-list', [\App\Http\Controllers\Admin\ServiceGuideController::class, 'index'])->name('guides');

        Route::get('/', [\App\Http\Controllers\Organizer\ServiceController::class, 'index'])->name('services');
        Route::get('/create', [\App\Http\Controllers\Organizer\ServiceController::class, 'create'])->name('service.create');
        Route::get('/{id}', [\App\Http\Controllers\Organizer\ServiceController::class, 'show'])->name('service.show');
        Route::post('/', [\App\Http\Controllers\Organizer\ServiceController::class, 'store'])->name('service.store');
        Route::post('/{id}', [\App\Http\Controllers\Organizer\ServiceController::class, 'update'])->name('service.update');
        Route::get('/{id}/destroy', [\App\Http\Controllers\Organizer\ServiceController::class, 'destroy'])->name('service.destroy');

        /** Guides */
        Route::get('/{service_id}/guides', [\App\Http\Controllers\Admin\ServiceGuideController::class, 'index']);
        Route::get('/{service_id}/guide', [\App\Http\Controllers\Admin\ServiceGuideController::class, 'show'])->name('service.guide');
        Route::post('/{service_id}/guide', [\App\Http\Controllers\Admin\ServiceGuideController::class, 'store'])->name('service-guide.store');
        Route::post('/{service_id}/guide/{id}', [\App\Http\Controllers\Admin\ServiceGuideController::class, 'update'])->name('service-guide.update');
        Route::delete('/{service_id}/guide/{id}', [\App\Http\Controllers\Admin\ServiceGuideController::class, 'destroy'])->name('service-guide.destroy');
        Route::post('/{service_id}/guide/{id}/social', [\App\Http\Controllers\Admin\ServiceGuideController::class, 'social'])->name('service-guide-social.update');

        /** Questions */
        Route::get('/{service_id}/questions', [\App\Http\Controllers\Admin\ServiceQuestionController::class, 'index'])->name('service.questions');
        Route::get('/{service_id}/question/{id}', [\App\Http\Controllers\Admin\ServiceQuestionController::class, 'show'])->name('service-question.show');
        Route::get('/{service_id}/question', [\App\Http\Controllers\Admin\ServiceQuestionController::class, 'create'])->name('service-question.create');
        Route::post('/{service_id}/question', [\App\Http\Controllers\Admin\ServiceQuestionController::class, 'store'])->name('service-question.store');
        Route::post('/{service_id}/question/{id}', [\App\Http\Controllers\Admin\ServiceQuestionController::class, 'update'])->name('service-question.update');
        Route::get('/{service_id}/question/{id}/destroy', [\App\Http\Controllers\Admin\ServiceQuestionController::class, 'destroy'])->name('service-question.destroy');
        /** end Questions */
    });
    /** end Services */
});

Route::view('', 'web.services.index');

/** Cities */
Route::get('/cities', [\App\Http\Controllers\CityController::class, 'index']);
Route::get('/cities/{id}', [\App\Http\Controllers\CityController::class, 'index']);
Route::get('/cities/{id}/districts', [\App\Http\Controllers\CityController::class, 'districts'])->name('front.city.districts');
/** end Cities */

/** Categories */
Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
/** end Categories */

Route::get('faq', [\App\Http\Controllers\FaqController::class, 'index'])->name('public-faq.list');
Route::get('announcements', [\App\Http\Controllers\AnnouncementController::class, 'index'])->name('public-announcements.list');
Route::get('validators', [\App\Http\Controllers\ValidatorController::class, 'index'])->name('public-announcements.list');
Route::get('sliders', [\App\Http\Controllers\SliderController::class, 'index'])->name('public-sliders.list');

/** Services */
Route::get('etkinlikler', [\App\Http\Controllers\ServiceController::class, 'index'])->name('front.services');
Route::get('etkinlikler/son-eklenenler', [\App\Http\Controllers\ServiceController::class, 'lastAdded'])->name('front.services.last-added');
Route::view('etkinlik-ara', 'web.services.search');
Route::get('sehir-etkinlikleri/{slug}/{count?}', [\App\Http\Controllers\ServiceController::class, 'getCityServices']);
Route::post('etkinlik-ara', [\App\Http\Controllers\ServiceController::class, 'searchDetail'])->name('front.service-search-detail');
Route::get('etkinlikler/{slug}', [\App\Http\Controllers\ServiceController::class, 'show']);
/** end Services */


Route::get('/search/{word}', [\App\Http\Controllers\ServiceController::class, 'search']);
Route::get('/{id}', [\App\Http\Controllers\ServiceController::class, 'show']);
Route::get('/service/{id}/guide', [\App\Http\Controllers\ServiceController::class, 'guide']);
Route::get('/{id}/questions', [\App\Http\Controllers\ServiceController::class, 'guide']);
//Route::get('/{id}/questions/{id}', [\App\Http\Controllers\ServiceController::class, 'guide']);

