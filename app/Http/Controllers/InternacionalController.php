<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Internacional;

class InternacionalController extends Controller
{
    public function index()
    {
        if (auth()->check()) {                                  // El usuario inicio sesión
            $role = auth()->user()->role;
            if ($role == 'revisor') {                           // El Revisor ve las noticias pendientes de aprobación y las ya aprobadas
                $internacionales = Internacional::whereIn('status', ['pending', 'approved'])->get();
            } elseif ($role == 'editor') {                      // Si el usuario es editor, ve sus noticias y todas las aprobadas
                $internacionales = Internacional::where('user_id', auth()->id())->orWhere('status', 'approved')->get();
            } else {                                            // Cualquier otro rol solo ve noticias aprobadas
                $internacionales = Internacional::where('status', 'approved')->get();
            }
        } else {                                                // Si es un visitante sin registrarse, solo ve noticias aprobadas
            $internacionales = Internacional::where('status', 'approved')->get();
        }

        return view('internacionales.index', compact('internacionales'));
    }

    public function create()
    {
        // Muestra el formulario para crear una nueva noticia internacional
        return view('internacionales.create');
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

        $internacional = new Internacional();
        if ($request->hasFile('imagen')) { // Si subieron una imagen, la guarda en la carpeta pública
            $path = $request->file('imagen')->store('images', 'public');
            $internacional->imagen = $path;
        }
        $internacional->titulo      = $request->titulo;         // Asigna los valores al objeto
        $internacional->descripcion = $request->descripcion;
        $internacional->contenido   = $request->contenido;
        $internacional->user_id     = auth()->id();         // Guarda quién la escribió
        $internacional->status      = 'pending';        // Empieza con estado pendiente para que el Revisor la revise
        $internacional->save();

        return redirect()->route('internacionales.index');
    }

    public function show(Internacional $internacional)
    {
        // Solo mostrar si está aprobado o si el usuario es editor/revisor
        if ($internacional->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404); // Error 404 (No encontrado)
        }

        return view('internacionales.show', compact('internacional'));
    }

    public function edit(Internacional $internacional)
    {
        // Solo el editor dueño puede editar una noticia rechazada
        if ($internacional->status !== 'rejected' || $internacional->user_id !== auth()->id()) {
            abort(403); // Error 403 (No autorizado)
        }

        return view('internacionales.edit', compact('internacional'));
    }

    public function update(Request $request, Internacional $internacional)
    {
        // Solo el editor dueño puede actualizar una noticia rechazada
        if ($internacional->status !== 'rejected' || $internacional->user_id !== auth()->id()) {
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
            $internacional->imagen = $path;
        }
        $internacional->titulo      = $request->titulo;
        $internacional->descripcion = $request->descripcion;
        $internacional->contenido   = $request->contenido;
        $internacional->status      = 'pending'; // Vuelve a revisión
        $internacional->save();

        return redirect()->route('internacionales.index');
    }

    public function destroy(Internacional $internacional) // El editor puede borrar sus noticias rechazadas y el revisor puede borrar las aprobadas
    {
        $user = auth()->user();
        $isEditorOwner = $user->role === 'editor' && $internacional->user_id === $user->id && $internacional->status === 'rejected';
        $isRevisor = $user->role === 'revisor' && $internacional->status === 'approved';

        if (!$isEditorOwner && !$isRevisor) {
            abort(403);
        }

        $internacional->delete();

        return back();
    }

    public function aprobar(Internacional $internacional) // Lo aprueba el revisor
    {
        $internacional->status = 'approved';
        $internacional->save();

        return back();
    }

    public function rechazar(Internacional $internacional) // Lo rechaza el revisor
    {
        $internacional->status = 'rejected';
        $internacional->save();

        return back();
    }
}

