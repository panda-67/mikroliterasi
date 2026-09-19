<?php

use App\Http\Controllers\ResearchProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource(
    'research-projects',
    ResearchProjectController::class
);
