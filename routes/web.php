<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;

Route::get('/', [TareaController::class, 'inicio'])->name('inicio');
Route::get('/deportes', [TareaController::class, 'deportes'])->name('deportes.index');
Route::get('/tecnologia', [TareaController::class, 'tecnologia'])->name('tecnologia.index');
Route::get('/internacionales', [TareaController::class, 'internacionales'])->name('internacionales.index');
Route::get('/clima', [TareaController::class, 'clima'])->name('clima.index');
Route::get('/locales', [TareaController::class, 'locales'])->name('locales.index');

Route::get('/createDeporte', [TareaController::class, 'createDeporte'])->name('deportes.create');
Route::get('/createTecnologia', [TareaController::class, 'createTecnologia'])->name('tecnologia.create');
Route::get('/createInternacional', [TareaController::class, 'createInternacional'])->name('internacionales.create');
Route::get('/createClima', [TareaController::class, 'createClima'])->name('clima.create');
Route::get('/createLocal', [TareaController::class, 'createLocal'])->name('locales.create');

Route::post('/agregarDeporte', [TareaController::class, 'agregarDeporte'])->name('deportes.agg');
Route::post('/agregarTecnologia', [TareaController::class, 'agregarTecnologia'])->name('tecnologia.agg');
Route::post('/agregarInternacional', [TareaController::class, 'agregarInternacional'])->name('internacionales.agg');
Route::post('/agregarClima', [TareaController::class, 'agregarClima'])->name('clima.agg');
Route::post('/agregarLocal', [TareaController::class, 'agregarLocal'])->name('locales.agg');
