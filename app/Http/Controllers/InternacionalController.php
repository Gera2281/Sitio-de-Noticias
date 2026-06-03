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
        // Usa la Policy para determinar si se puede ver la noticia, manteniendo el comportamiento de retornar 404
        if (auth()->check() ? auth()->user()->cannot('view', $internacional) : $internacional->status !== 'approved') {
            abort(404); // Error 404 (No encontrado)
        }

        return view('internacionales.show', compact('internacional'));
    }

    public function edit(Internacional $internacional)
    {
        // Autoriza la edición usando la Policy
        $this->authorize('update', $internacional);

        return view('internacionales.edit', compact('internacional'));
    }

    public function update(Request $request, Internacional $internacional)
    {
        // Autoriza la actualización usando la Policy
        $this->authorize('update', $internacional);

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

    public function destroy(Internacional $internacional)
    {
        // Autoriza la eliminación usando la Policy
        $this->authorize('delete', $internacional);

        $internacional->delete();

        return back();
    }

    public function aprobar(Internacional $internacional)
    {
        // Autoriza la revisión usando la Policy
        $this->authorize('review', $internacional);

        $internacional->status = 'approved';
        $internacional->save();

        return back();
    }

    public function rechazar(Internacional $internacional)
    {
        // Autoriza la revisión usando la Policy
        $this->authorize('review', $internacional);

        $internacional->status = 'rejected';
        $internacional->save();

        return back();
    }
}

