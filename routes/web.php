<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\SubChapterController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('reports', ReportController::class);

Route::post('reports/{report}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
Route::delete('chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
Route::post('chapters/{chapter}/sub-chapters', [SubChapterController::class, 'store'])->name('sub-chapters.store');
Route::delete('sub-chapters/{subChapter}', [SubChapterController::class, 'destroy'])->name('sub-chapters.destroy');
Route::put('sub-chapters/{subChapter}', [SubChapterController::class, 'update'])->name('sub-chapters.update');