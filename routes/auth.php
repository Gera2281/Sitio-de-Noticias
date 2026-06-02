<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // RUTA: Mostrar formulario de registro
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // RUTA: Procesar el registro de un nuevo usuario
    Route::post('register', [RegisteredUserController::class, 'store']);

    // RUTA: Mostrar formulario de inicio de sesión (Login)
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // RUTA: Procesar el inicio de sesión (enviar credenciales)
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // RUTA: Mostrar formulario para recuperar contraseña
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // RUTA: Enviar el enlace de recuperación de contraseña al correo
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // RUTA: Mostrar formulario para restablecer contraseña con un token
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // RUTA: Guardar la nueva contraseña restablecida
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    // RUTA: Mostrar aviso de verificación de correo pendiente
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // RUTA: Procesar la verificación al dar clic al enlace enviado por correo
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // RUTA: Reenviar el correo de verificación
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // RUTA: Mostrar confirmación de contraseña antes de acciones sensibles
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    // RUTA: Procesar la confirmación de la contraseña
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // RUTA: Actualizar la contraseña del usuario logueado
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // RUTA: Cerrar sesión (Logout)
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
