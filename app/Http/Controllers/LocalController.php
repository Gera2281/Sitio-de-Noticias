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
        // Usa la Policy para determinar si se puede ver la noticia, manteniendo el comportamiento de retornar 404
        if (Auth::user() ? Auth::user()->cannot('view', $local) : $local->status !== 'approved') {
            abort(404); // Error 404 (No encontrado)
        }

        return view('locales.show', compact('local'));
    }

    public function edit(Local $local)
    {
        // Autoriza la edición usando la Policy
        $this->authorize('update', $local);

        return view('locales.edit', compact('local'));
    }

    public function update(Request $request, Local $local)
    {
        // Autoriza la actualización usando la Policy
        $this->authorize('update', $local);

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

    public function destroy(Local $local)
    {
        // Autoriza la eliminación usando la Policy
        $this->authorize('delete', $local);

        $local->delete();

        return back();
    }

    public function aprobar(Local $local)
    {
        // Autoriza la revisión usando la Policy
        $this->authorize('review', $local);

        $local->status = 'approved';
        $local->save();

        return back();
    }

    public function rechazar(Local $local)
    {
        // Autoriza la revisión usando la Policy
        $this->authorize('review', $local);

        $local->status = 'rejected';
        $local->save();

        return back();
    }
}

