<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Local;
use Illuminate\Support\Facades\Auth;

class LocalController extends Controller
{
    public function index()
    {
        if (Auth::check()) {                                  // El usuario inicio sesión
            $role = Auth::user()->role;
            if ($role == 'revisor') {                           // El Revisor ve las noticias pendientes de aprobación y las ya aprobadas
                $locales = Local::whereIn('status', ['pending', 'approved'])->get();
            } elseif ($role == 'editor') {                      // Si el usuario es editor, ve sus noticias y todas las aprobadas
                $locales = Local::where('user_id', Auth::id())->orWhere('status', 'approved')->get();
            } else {                                            // Cualquier otro rol solo ve noticias aprobadas
                $locales = Local::where('status', 'approved')->get();
            }
        } else {                                                // Si es un visitante sin registrarse, solo ve noticias aprobadas
            $locales = Local::where('status', 'approved')->get();
        }

        return view('locales.index', compact('locales'));
    }

    public function create()
    {
        // Muestra el formulario para crear una nueva noticia local
        return view('locales.create');
    }

    public function store(Request $request)
    {
        // Valida que los campos requeridos estén llenos y correctos
        $request->validate([
            'titulo'      => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'contenido'   => 'required|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
        ]);

        $local = new Local();
        if ($request->hasFile('imagen')) { // Si subieron una imagen, la guarda en la carpeta pública
            $path = $request->file('imagen')->store('images', 'public');
            $local->imagen = $path;
        }
        $local->titulo      = $request->titulo;         // Asigna los valores al objeto
        $local->descripcion = $request->descripcion;
        $local->contenido   = $request->contenido;
        $local->user_id     = Auth::id();         // Guarda quién la escribió
        $local->status      = 'pending';        // Empieza con estado pendiente para que el Revisor la revise
        $local->save();

        return redirect()->route('locales.index');
    }

    public function show(Local $local)
    {
        // Solo mostrar si está aprobado o si el usuario es editor/revisor
        if ($local->status !== 'approved' && (!Auth::check() || (Auth::user()->role !== 'editor' && Auth::user()->role !== 'revisor'))) {
            abort(404); // Error 404 (No encontrado)
        }

        return view('locales.show', compact('local'));
    }

    public function edit(Local $local)
    {
        // Solo el editor dueño puede editar una noticia rechazada
        if ($local->status !== 'rejected' || $local->user_id !== Auth::id()) {
            abort(403); // Error 403 (No autorizado)
        }

        return view('locales.edit', compact('local'));
    }

    public function update(Request $request, Local $local)
    {
        // Solo el editor dueño puede actualizar una noticia rechazada
        if ($local->status !== 'rejected' || $local->user_id !== Auth::id()) {
            abort(403); // Error 403 (No autorizado)
        }

        $request->validate([
            'titulo'      => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'contenido'   => 'required|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $local->imagen = $path;
        }
        $local->titulo      = $request->titulo;
        $local->descripcion = $request->descripcion;
        $local->contenido   = $request->contenido;
        $local->status      = 'pending'; // Vuelve a revisión
        $local->save();

        return redirect()->route('locales.index');
    }

    public function destroy(Local $local) // El editor puede borrar sus noticias rechazadas y el revisor puede borrar las aprobadas
    {
        $user = Auth::user();
        $isEditorOwner = $user->role === 'editor' && $local->user_id === $user->id && $local->status === 'rejected';
        $isRevisor = $user->role === 'revisor' && $local->status === 'approved';

        if (!$isEditorOwner && !$isRevisor) {
            abort(403);
        }

        $local->delete();

        return back();
    }

    public function aprobar(Local $local) // Lo aprueba el revisor
    {
        $local->status = 'approved';
        $local->save();

        return back();
    }

    public function rechazar(Local $local) // Lo rechaza el revisor
    {
        $local->status = 'rejected';
        $local->save();

        return back();
    }
}

