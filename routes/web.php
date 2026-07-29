<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChapterController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('reports', ReportController::class);

Route::post('reports/{report}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
Route::delete('chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');