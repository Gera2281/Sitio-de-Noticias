<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clima;
use Illuminate\Support\Facades\Auth;

class ClimaController extends Controller
{
    public function index()
    {
        if (Auth::check()) {                                  // El usuario inicio sesión
            $role = Auth::user()->role;
            if ($role == 'revisor') {                           // El Revisor ve las noticias pendientes de aprobación y las ya aprobadas
                $clima = Clima::whereIn('status', ['pending', 'approved'])->get();
            } elseif ($role == 'editor') {                      // Si el usuario es editor, ve sus noticias y todas las aprobadas
                $clima = Clima::where('user_id', Auth::id())->orWhere('status', 'approved')->get();
            } else {                                            // Cualquier otro rol solo ve noticias aprobadas
                $clima = Clima::where('status', 'approved')->get();
            }
        } else {                                                // Si es un visitante sin registrarse, solo ve noticias aprobadas
            $clima = Clima::where('status', 'approved')->get();
        }

        return view('clima.index', compact('clima'));
    }

    public function create()
    {
        // Muestra el formulario para crear una nueva noticia de clima
        return view('clima.create');
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

        $clima = new Clima();
        if ($request->hasFile('imagen')) { // Si subieron una imagen, la guarda en la carpeta pública
            $path = $request->file('imagen')->store('images', 'public');
            $clima->imagen = $path;
        }
        $clima->titulo      = $request->titulo;         // Asigna los valores al objeto
        $clima->descripcion = $request->descripcion;
        $clima->contenido   = $request->contenido;
        $clima->user_id     = Auth::id();         // Guarda quién la escribió
        $clima->status      = 'pending';        // Empieza con estado pendiente para que el Revisor la revise
        $clima->save();

        return redirect()->route('clima.index');
    }

    public function show(Clima $clima)
    {
        // Solo mostrar si está aprobado o si el usuario es editor/revisor
        if ($clima->status !== 'approved' && (!Auth::check() || (Auth::user()->role !== 'editor' && Auth::user()->role !== 'revisor'))) {
            abort(404); // Error 404 (No encontrado)
        }

        return view('clima.show', compact('clima'));
    }

    public function edit(Clima $clima)
    {
        // Solo el editor dueño puede editar una noticia rechazada
        if ($clima->status !== 'rejected' || $clima->user_id !== Auth::id()) {
            abort(403); // Error 403 (No autorizado)
        }

        return view('clima.edit', compact('clima'));
    }

    public function update(Request $request, Clima $clima)
    {
        // Solo el editor dueño puede actualizar una noticia rechazada
        if ($clima->status !== 'rejected' || $clima->user_id !== Auth::id()) {
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
            $clima->imagen = $path;
        }
        $clima->titulo      = $request->titulo;
        $clima->descripcion = $request->descripcion;
        $clima->contenido   = $request->contenido;
        $clima->status      = 'pending'; // Vuelve a revisión
        $clima->save();

        return redirect()->route('clima.index');
    }

    public function destroy(Clima $clima) // El editor puede borrar sus noticias rechazadas y el revisor puede borrar las aprobadas
    {
        $user = Auth::user();
        $isEditorOwner = $user->role === 'editor' && $clima->user_id === $user->id && in_array($clima->status, ['rejected', 'approved']);
        $isRevisor = $user->role === 'revisor' && $clima->status === 'approved';

        if (!$isEditorOwner && !$isRevisor) {
            abort(403);
        }

        $clima->delete();

        return back();
    }

    public function aprobar(Clima $clima) // Lo aprueba el revisor
    {
        $clima->status = 'approved';
        $clima->save();

        return back();
    }

    public function rechazar(Clima $clima) // Lo rechaza el revisor
    {
        $clima->status = 'rejected';
        $clima->save();

        return back();
    }
}

