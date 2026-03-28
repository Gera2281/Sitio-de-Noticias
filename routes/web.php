<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;

Route::get('/', [TareaController::class, 'inicio'])->name('inicio');
Route::get('/productos', [TareaController::class, 'productos'])->name('productos');
Route::get('/tareas', [TareaController::class, 'tareas'])->name('tareas');
Route::get('/create', [TareaController::class, 'create'])->name('tareas.create');
Route::get('/createP', [TareaController::class, 'createP'])->name('productos.createP');
Route::post('/store', [TareaController::class, 'store'])->name('tareas.store');
Route::post('/storeP', [TareaController::class, 'storeP'])->name('productos.storeP');