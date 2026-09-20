<?php

use App\Http\Controllers\ResearchProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource(
    'research-projects',
    ResearchProjectController::class
);
