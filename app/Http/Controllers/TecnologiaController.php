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
        // Usa la Policy para determinar si se puede ver la noticia, manteniendo el comportamiento de retornar 404
        if (Auth::user() ? Auth::user()->cannot('view', $tecnologia) : $tecnologia->status !== 'approved') {
            abort(404); // Error 404 (No encontrado)
        }

        return view('tecnologia.show', compact('tecnologia'));
    }

    public function edit(Tecnologia $tecnologia)
    {
        // Autoriza la edición usando la Policy
        $this->authorize('update', $tecnologia);

        return view('tecnologia.edit', compact('tecnologia'));
    }

    public function update(Request $request, Tecnologia $tecnologia)
    {
        // Autoriza la actualización usando la Policy
        $this->authorize('update', $tecnologia);

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

    public function destroy(Tecnologia $tecnologia)
    {
        // Autoriza la eliminación usando la Policy
        $this->authorize('delete', $tecnologia);

        $tecnologia->delete();

        return back();
    }

    public function aprobar(Tecnologia $tecnologia)
    {
        // Autoriza la revisión usando la Policy
        $this->authorize('review', $tecnologia);

        $tecnologia->status = 'approved';
        $tecnologia->save();

        return back();
    }

    public function rechazar(Tecnologia $tecnologia)
    {
        // Autoriza la revisión usando la Policy
        $this->authorize('review', $tecnologia);

        $tecnologia->status = 'rejected';
        $tecnologia->save();

        return back();
    }
}

