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
        // Usa la Policy para determinar si se puede ver la noticia, manteniendo el comportamiento de retornar 404
        if (Auth::user() ? Auth::user()->cannot('view', $clima) : $clima->status !== 'approved') {
            abort(404); // Error 404 (No encontrado)
        }

        return view('clima.show', compact('clima'));
    }

    public function edit(Clima $clima)
    {
        // Autoriza la edición usando la Policy
        $this->authorize('update', $clima);

        return view('clima.edit', compact('clima'));
    }

    public function update(Request $request, Clima $clima)
    {
        // Autoriza la actualización usando la Policy
        $this->authorize('update', $clima);

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

    public function destroy(Clima $clima)
    {
        // Autoriza la eliminación usando la Policy
        $this->authorize('delete', $clima);

        $clima->delete();

        return back();
    }

    public function aprobar(Clima $clima)
    {
        // Autoriza la revisión usando la Policy
        $this->authorize('review', $clima);

        $clima->status = 'approved';
        $clima->save();

        return back();
    }

    public function rechazar(Clima $clima)
    {
        // Autoriza la revisión usando la Policy
        $this->authorize('review', $clima);

        $clima->status = 'rejected';
        $clima->save();

        return back();
    }
}

