<?php

use App\Http\Controllers\zSectionController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [zSectionController::class, 'index'])->name('index');
Route::post('/get-metrics', [zSectionController::class, 'getMetrics'])->name('get.metrics');
Route::post('/save-metric-run', [zSectionController::class, 'saveMetricRun'])->name('save.metric.run');
Route::get('/history', [zSectionController::class, 'history'])->name('history');
