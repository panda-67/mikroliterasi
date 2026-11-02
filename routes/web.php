<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ResearchAreaController;
use App\Http\Controllers\ResearchProjectController;
use App\Http\Controllers\TeachingMaterialController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/privacy-policy', 'legal.privacy-policy')->name('privacy-policy');
Route::view('/terms-of-service', 'legal.terms-of-service')->name('terms-of-service');

Route::controller(PostController::class)->name('posts.')
    ->group(function () {
        Route::get('/posts', 'index')->name('index');
        Route::get('/posts/{post}', 'show')->name('show');
    });

Route::resource('research-projects', ResearchProjectController::class);

Route::delete(
    '/research-projects/{researchProject}/featured-image',
    [ResearchProjectController::class, 'removeFeaturedImage']
)->name('research-projects.featured-image.destroy');

Route::resource('publications', PublicationController::class);
Route::resource('people', PersonController::class);

Route::controller(TeachingMaterialController::class)
    ->name('teaching-materials.')
    ->group(function () {
        Route::get('/materi-ajar', 'index')->name('index');
        Route::get('/materi-ajar/{teachingMaterial}', 'show')->name('show');
    });

Route::prefix('dashboard')->name('dashboard.')->group(function () {

    Route::get('/', DashboardController::class)->name('index');

    Route::get('/posts', [
        PostController::class,
        'dashboardIndex'
    ])->name('posts.index');

    Route::get('research-projects', [
        ResearchProjectController::class,
        'dashboardIndex',
    ])->name('research-projects.index');

    Route::get('publications', [
        PublicationController::class,
        'dashboardIndex'
    ])->name('publications.index');

    Route::get('people', [
        PersonController::class,
        'dashboardIndex'
    ])->name('people.index');

    Route::get('/teaching-materials', [
        TeachingMaterialController::class,
        'dashboardIndex',
    ])->name('teaching-materials.index');

    Route::resource('research-areas', ResearchAreaController::class)
        ->except('create', 'show', 'edit')
        ->names('research-areas');

    Route::resource('posts', PostController::class)
        ->except(['index', 'show']);

    Route::resource('teaching-materials', TeachingMaterialController::class)
        ->except(['index', 'show']);
});

Route::prefix('auth/google')->name('google.')->controller(GoogleAuthController::class)
    ->group(function () {
        Route::get('/', 'redirect')->name('redirect');
        Route::get('/callback', 'callback')->name('callback');
    });
