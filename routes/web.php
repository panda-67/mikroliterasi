<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ResearchAreaController;
use App\Http\Controllers\ResearchProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', DashboardController::class)
    ->name('dashboard.index');

Route::resource('dashboard/research-areas', ResearchAreaController::class)
    ->except('create', 'show', 'edit')
    ->names('dashboard.research-areas');

Route::get('/dashboard/research-projects', [
    ResearchProjectController::class,
    'dashboardIndex',
])->name('dashboard.research-projects.index');

Route::get('/dashboard/publications', [
    PublicationController::class,
    'dashboardIndex'
])->name('dashboard.publications.index');

Route::get('/dashboard/people', [
    PersonController::class,
    'dashboardIndex'
])->name('dashboard.people.index');

Route::resource('research-projects', ResearchProjectController::class);

Route::delete(
    '/research-projects/{researchProject}/featured-image',
    [ResearchProjectController::class, 'removeFeaturedImage']
)->name('research-projects.featured-image.destroy');

Route::resource('publications', PublicationController::class);
Route::resource('people', PersonController::class);
