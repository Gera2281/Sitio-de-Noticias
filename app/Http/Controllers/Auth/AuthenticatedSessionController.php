<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra la vista del formulario de login.
     * Retorna la plantilla Blade: resources/views/auth/login.blade.php
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa la solicitud de inicio de sesión.
     * 
     * 1. Valida e intenta autenticar las credenciales usando LoginRequest.
     * 2. Regenera la sesión para evitar ataques de fijación de sesión.
     * 3. Redirecciona al usuario a la página de inicio o a la ruta que intentaba acceder.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Ejecuta la autenticación (definida en LoginRequest.php)
        $request->authenticate();

        // Regenera la sesión del usuario para seguridad
        $request->session()->regenerate();

        // Redirecciona al inicio o a la página que el usuario intentó acceder antes de ser redirigido
        return redirect()->intended(route('inicio', absolute: false));
    }

    /**
     * Cierra la sesión activa del usuario (Logout).
     * 
     * 1. Desconecta al usuario del guard 'web'.
     * 2. Invalida la sesión actual.
     * 3. Regenera el token CSRF para prevenir exploits.
     * 4. Redirecciona a la página principal.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Cierra sesión
        Auth::guard('web')->logout();

        // Invalida la sesión actual del navegador
        $request->session()->invalidate();

        // Regenera el token CSRF para la seguridad de futuras peticiones
        $request->session()->regenerateToken();

        // Redirecciona al home
        return redirect('/');
    }
}
