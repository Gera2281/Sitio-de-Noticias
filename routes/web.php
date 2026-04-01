<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\TareaController;

Route::get('/', [TareaController::class, 'inicio'])->name('inicio');
Route::get('/deportes', [TareaController::class, 'deportes'])->name('deportes.index');
Route::get('/tecnologia', [TareaController::class, 'tecnologia'])->name('tecnologia.index');
Route::get('/internacionales', [TareaController::class, 'internacionales'])->name('internacionales.index');
Route::get('/clima', [TareaController::class, 'clima'])->name('clima.index');
Route::get('/locales', [TareaController::class, 'locales'])->name('locales.index');

Route::middleware(['auth', 'role:editor'])->group(function () {
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
});

Route::middleware(['auth', 'role:revisor'])->group(function () {
    Route::patch('/deportes/{deporte}/aprobar', [TareaController::class, 'aprobarDeporte'])->name('deportes.aprobar');
    Route::patch('/deportes/{deporte}/rechazar', [TareaController::class, 'rechazarDeporte'])->name('deportes.rechazar');

    Route::patch('/tecnologia/{tecnologia}/aprobar', [TareaController::class, 'aprobarTecnologia'])->name('tecnologia.aprobar');
    Route::patch('/tecnologia/{tecnologia}/rechazar', [TareaController::class, 'rechazarTecnologia'])->name('tecnologia.rechazar');

    Route::patch('/internacionales/{internacional}/aprobar', [TareaController::class, 'aprobarInternacional'])->name('internacionales.aprobar');
    Route::patch('/internacionales/{internacional}/rechazar', [TareaController::class, 'rechazarInternacional'])->name('internacionales.rechazar');

    Route::patch('/clima/{clima}/aprobar', [TareaController::class, 'aprobarClima'])->name('clima.aprobar');
    Route::patch('/clima/{clima}/rechazar', [TareaController::class, 'rechazarClima'])->name('clima.rechazar');

    Route::patch('/locales/{local}/aprobar', [TareaController::class, 'aprobarLocal'])->name('locales.aprobar');
    Route::patch('/locales/{local}/rechazar', [TareaController::class, 'rechazarLocal'])->name('locales.rechazar');
});
