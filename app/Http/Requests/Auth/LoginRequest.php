<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     * En este caso, cualquiera puede intentar iniciar sesión, por lo que retorna true.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación aplicadas a la solicitud del formulario.
     * Define qué campos son requeridos y su formato.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'], // El email es obligatorio, debe ser texto y con formato de correo válido
            'password' => ['required', 'string'],       // La contraseña es obligatoria y debe ser texto
        ];
    }

    /**
     * Intenta autenticar las credenciales proporcionadas en la solicitud.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        // 1. Verifica que no se haya superado el límite de intentos permitidos (evita ataques de fuerza bruta)
        $this->ensureIsNotRateLimited();

        // 2. Intenta hacer login usando Auth::attempt con email, contraseña y el checkbox de recordar sesión (remember)
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Si el intento falla, suma un intento fallido al limitador de velocidad
            RateLimiter::hit($this->throttleKey());

            // Lanza una excepción de validación que muestra el error de credenciales incorrectas en la vista
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // 3. Si la autenticación es exitosa, reinicia el limitador de intentos fallidos
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Asegura que el usuario no haya superado el límite de intentos de login.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        // Permite máximo 5 intentos fallidos
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        // Lanza un evento de bloqueo (Lockout)
        event(new Lockout($this));

        // Obtiene los segundos que debe esperar el usuario antes de volver a intentar
        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Lanza un error indicando el tiempo de espera restante
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Genera una clave única para identificar el límite de intentos por usuario/IP.
     * Se compone del correo electrónico en minúsculas y la dirección IP del cliente.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
