<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;

Route::get('/', [TareaController::class, 'inicio'])->name('inicio');
Route::get('/deportes', [TareaController::class, 'deportes'])->name('deportes.index');
Route::get('/tecnologia', [TareaController::class, 'tecnologia'])->name('tecnologia.index');
Route::get('/productos', [TareaController::class, 'productos'])->name('productos');
Route::get('/createDeporte', [TareaController::class, 'createDeporte'])->name('deportes.create');
Route::get('/createTecnologia', [TareaController::class, 'createTecnologia'])->name('tecnologia.create');
Route::get('/createP', [TareaController::class, 'createP'])->name('productos.createP');
Route::post('/agregarDeporte', [TareaController::class, 'agregarDeporte'])->name('deportes.agg');
Route::post('/agregarTecnologia', [TareaController::class, 'agregarTecnologia'])->name('tecnologia.agg');
Route::post('/storeP', [TareaController::class, 'storeP'])->name('productos.storeP');
