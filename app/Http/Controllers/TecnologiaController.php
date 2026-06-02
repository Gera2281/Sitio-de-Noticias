<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tecnologia;
use Illuminate\Support\Facades\Auth;

class TecnologiaController extends Controller
{
    public function index()
    {
        if (Auth::check()) {                                  // El usuario inicio sesión
            $role = Auth::user()->role;
            if ($role == 'revisor') {                           // El Revisor ve las noticias pendientes de aprobación y las ya aprobadas
                $tecnologia = Tecnologia::whereIn('status', ['pending', 'approved'])->get();
            } elseif ($role == 'editor') {                      // Si el usuario es editor, ve sus noticias y todas las aprobadas
                $tecnologia = Tecnologia::where('user_id', Auth::id())->orWhere('status', 'approved')->get();
            } else {                                            // Cualquier otro rol solo ve noticias aprobadas
                $tecnologia = Tecnologia::where('status', 'approved')->get();
            }
        } else {                                                // Si es un visitante sin registrarse, solo ve noticias aprobadas
            $tecnologia = Tecnologia::where('status', 'approved')->get();
        }

        return view('tecnologia.index', compact('tecnologia'));
    }

    public function create()
    {
        // Muestra el formulario para crear una nueva noticia de tecnología
        return view('tecnologia.create');
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

        $tecnologia = new Tecnologia();
        if ($request->hasFile('imagen')) { // Si subieron una imagen, la guarda en la carpeta pública
            $path = $request->file('imagen')->store('images', 'public');
            $tecnologia->imagen = $path;
        }
        $tecnologia->titulo      = $request->titulo;         // Asigna los valores al objeto
        $tecnologia->descripcion = $request->descripcion;
        $tecnologia->contenido   = $request->contenido;
        $tecnologia->user_id     = Auth::id();         // Guarda quién la escribió
        $tecnologia->status      = 'pending';        // Empieza con estado pendiente para que el Revisor la revise
        $tecnologia->save();

        return redirect()->route('tecnologia.index');
    }

    public function show(Tecnologia $tecnologia)
    {
        // Solo mostrar si está aprobado o si el usuario es editor/revisor
        if ($tecnologia->status !== 'approved' && (!Auth::check() || (Auth::user()->role !== 'editor' && Auth::user()->role !== 'revisor'))) {
            abort(404); // Error 404 (No encontrado)
        }

        return view('tecnologia.show', compact('tecnologia'));
    }

    public function edit(Tecnologia $tecnologia)
    {
        // Solo el editor dueño puede editar una noticia rechazada
        if ($tecnologia->status !== 'rejected' || $tecnologia->user_id !== Auth::id()) {
            abort(403); // Error 403 (No autorizado)
        }

        return view('tecnologia.edit', compact('tecnologia'));
    }

    public function update(Request $request, Tecnologia $tecnologia)
    {
        // Solo el editor dueño puede actualizar una noticia rechazada
        if ($tecnologia->status !== 'rejected' || $tecnologia->user_id !== Auth::id()) {
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
            $tecnologia->imagen = $path;
        }
        $tecnologia->titulo      = $request->titulo;
        $tecnologia->descripcion = $request->descripcion;
        $tecnologia->contenido   = $request->contenido;
        $tecnologia->status      = 'pending'; // Vuelve a revisión
        $tecnologia->save();

        return redirect()->route('tecnologia.index');
    }

    public function destroy(Tecnologia $tecnologia) // El editor puede borrar sus noticias rechazadas y el revisor puede borrar las aprobadas
    {
        $user = Auth::user();
        $isEditorOwner = $user->role === 'editor' && $tecnologia->user_id === $user->id && in_array($tecnologia->status, ['rejected', 'approved']);
        $isRevisor = $user->role === 'revisor' && $tecnologia->status === 'approved';

        if (!$isEditorOwner && !$isRevisor) {
            abort(403);
        }

        $tecnologia->delete();

        return back();
    }

    public function aprobar(Tecnologia $tecnologia) // Lo aprueba el revisor
    {
        $tecnologia->status = 'approved';
        $tecnologia->save();

        return back();
    }

    public function rechazar(Tecnologia $tecnologia) // Lo rechaza el revisor
    {
        $tecnologia->status = 'rejected';
        $tecnologia->save();

        return back();
    }
}

