<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\DeporteController;
use App\Http\Controllers\TecnologiaController;
use App\Http\Controllers\InternacionalController;
use App\Http\Controllers\ClimaController;
use App\Http\Controllers\LocalController;
use Illuminate\Support\Facades\Route;

//Perfil 
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

//Inicio
Route::get('/', [InicioController::class, 'index'])->name('inicio');

// Deportes
Route::get('/deportes', [DeporteController::class, 'index'])->name('deportes.index');
Route::get('/deportes/{deporte}', [DeporteController::class, 'show'])->name('deportes.show');

Route::middleware(['auth', 'role:editor'])->group(function () {
    Route::get('/createDeporte', [DeporteController::class, 'create'])->name('deportes.create');
    Route::post('/agregarDeporte', [DeporteController::class, 'store'])->name('deportes.agg');
    Route::get('/deportes/{deporte}/edit', [DeporteController::class, 'edit'])->name('deportes.edit');
    Route::put('/deportes/{deporte}', [DeporteController::class, 'update'])->name('deportes.update');
});

Route::middleware(['auth', 'role:revisor'])->group(function () {
    Route::patch('/deportes/{deporte}/aprobar', [DeporteController::class, 'aprobar'])->name('deportes.aprobar');
    Route::patch('/deportes/{deporte}/rechazar', [DeporteController::class, 'rechazar'])->name('deportes.rechazar');
});

//Tecnología 
Route::get('/tecnologia', [TecnologiaController::class, 'index'])->name('tecnologia.index');
Route::get('/tecnologia/{tecnologia}', [TecnologiaController::class, 'show'])->name('tecnologia.show');

Route::middleware(['auth', 'role:editor'])->group(function () {
    Route::get('/createTecnologia', [TecnologiaController::class, 'create'])->name('tecnologia.create');
    Route::post('/agregarTecnologia', [TecnologiaController::class, 'store'])->name('tecnologia.agg');
    Route::get('/tecnologia/{tecnologia}/edit', [TecnologiaController::class, 'edit'])->name('tecnologia.edit');
    Route::put('/tecnologia/{tecnologia}', [TecnologiaController::class, 'update'])->name('tecnologia.update');
});

Route::middleware(['auth', 'role:revisor'])->group(function () {
    Route::patch('/tecnologia/{tecnologia}/aprobar', [TecnologiaController::class, 'aprobar'])->name('tecnologia.aprobar');
    Route::patch('/tecnologia/{tecnologia}/rechazar', [TecnologiaController::class, 'rechazar'])->name('tecnologia.rechazar');
});

//Internacionales
Route::get('/internacionales', [InternacionalController::class, 'index'])->name('internacionales.index');
Route::get('/internacionales/{internacional}', [InternacionalController::class, 'show'])->name('internacionales.show');

Route::middleware(['auth', 'role:editor'])->group(function () {
    Route::get('/createInternacional', [InternacionalController::class, 'create'])->name('internacionales.create');
    Route::post('/agregarInternacional', [InternacionalController::class, 'store'])->name('internacionales.agg');
    Route::get('/internacionales/{internacional}/edit', [InternacionalController::class, 'edit'])->name('internacionales.edit');
    Route::put('/internacionales/{internacional}', [InternacionalController::class, 'update'])->name('internacionales.update');
});

Route::middleware(['auth', 'role:revisor'])->group(function () {
    Route::patch('/internacionales/{internacional}/aprobar', [InternacionalController::class, 'aprobar'])->name('internacionales.aprobar');
    Route::patch('/internacionales/{internacional}/rechazar', [InternacionalController::class, 'rechazar'])->name('internacionales.rechazar');
});

//Clima
Route::get('/clima', [ClimaController::class, 'index'])->name('clima.index');
Route::get('/clima/{clima}', [ClimaController::class, 'show'])->name('clima.show');

Route::middleware(['auth', 'role:editor'])->group(function () {
    Route::get('/createClima', [ClimaController::class, 'create'])->name('clima.create');
    Route::post('/agregarClima', [ClimaController::class, 'store'])->name('clima.agg');
    Route::get('/clima/{clima}/edit', [ClimaController::class, 'edit'])->name('clima.edit');
    Route::put('/clima/{clima}', [ClimaController::class, 'update'])->name('clima.update');
});

Route::middleware(['auth', 'role:revisor'])->group(function () {
    Route::patch('/clima/{clima}/aprobar', [ClimaController::class, 'aprobar'])->name('clima.aprobar');
    Route::patch('/clima/{clima}/rechazar', [ClimaController::class, 'rechazar'])->name('clima.rechazar');
});

//Locales
Route::get('/locales', [LocalController::class, 'index'])->name('locales.index');
Route::get('/locales/{local}', [LocalController::class, 'show'])->name('locales.show');

Route::middleware(['auth', 'role:editor'])->group(function () {
    Route::get('/createLocal', [LocalController::class, 'create'])->name('locales.create');
    Route::post('/agregarLocal', [LocalController::class, 'store'])->name('locales.agg');
    Route::get('/locales/{local}/edit', [LocalController::class, 'edit'])->name('locales.edit');
    Route::put('/locales/{local}', [LocalController::class, 'update'])->name('locales.update');
});

Route::middleware(['auth', 'role:revisor'])->group(function () {
    Route::patch('/locales/{local}/aprobar', [LocalController::class, 'aprobar'])->name('locales.aprobar');
    Route::patch('/locales/{local}/rechazar', [LocalController::class, 'rechazar'])->name('locales.rechazar');
});

// ─── Eliminar Noticias (Editor/Revisor) ───────────────────────────────────
Route::delete('/deportes/{deporte}', [App\Http\Controllers\DeporteController::class, 'destroy'])->name('deportes.destroy')->middleware('auth');
Route::delete('/tecnologia/{tecnologia}', [App\Http\Controllers\TecnologiaController::class, 'destroy'])->name('tecnologia.destroy')->middleware('auth');
Route::delete('/internacionales/{internacional}', [App\Http\Controllers\InternacionalController::class, 'destroy'])->name('internacionales.destroy')->middleware('auth');
Route::delete('/clima/{clima}', [App\Http\Controllers\ClimaController::class, 'destroy'])->name('clima.destroy')->middleware('auth');
Route::delete('/locales/{local}', [App\Http\Controllers\LocalController::class, 'destroy'])->name('locales.destroy')->middleware('auth');
