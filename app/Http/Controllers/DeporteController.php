<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deporte;
use Illuminate\Support\Facades\Auth;

class DeporteController extends Controller
{
    public function index()
    {
        if (Auth::check()) {                                  //El usuario inicio sesion
            $role = Auth::user()->role;
            if ($role == 'revisor') {                           // El Revisor ve las noticias pendientes de aprobación y las ya aprobadas
                $deportes = Deporte::whereIn('status', ['pending', 'approved'])->get();
            } elseif ($role == 'editor') {                      //Si el usuario es editor ve sus noticias rechazadas y todas las aprobadas
                $deportes = Deporte::where('user_id', Auth::id())->orWhere('status', 'approved')->get();
            } else {                                            // Cualquier otro rol solo ve noticias aprobadas
                $deportes = Deporte::where('status', 'approved')->get();
            }
        } else {                                                // Si es un visitante sin registrarse solo ve noticias aprobadas
            $deportes = Deporte::where('status', 'approved')->get();
        }

        return view('deportes.index', compact('deportes'));
    }

    public function create()
    {
        return view('deportes.create');
    }

    public function store(Request $request)
    {
        $request->validate([ //Valida que los campos requeridos
            'titulo'      => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'contenido'   => 'required|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
        ]);

        $deporte = new Deporte();
        if ($request->hasFile('imagen')) { //Si subieron una imagen, la guarda en la carpeta pública
            $path = $request->file('imagen')->store('images', 'public');
            $deporte->imagen = $path;
        }
        $deporte->titulo      = $request->titulo;         //Asigna los valores al objeto
        $deporte->descripcion = $request->descripcion;
        $deporte->contenido   = $request->contenido;
        $deporte->user_id     = Auth::id();         //Guarda quién la escribió
        $deporte->status      = 'pending';        //Empieza con estado pendiente para que el Revisor la revise
        $deporte->save();

        return redirect()->route('deportes.index');
    }

    public function show(Deporte $deporte)
    {
        // Usa la Policy para determinar si se puede ver la noticia, manteniendo el comportamiento de retornar 404
        if (Auth::user() ? Auth::user()->cannot('view', $deporte) : $deporte->status !== 'approved') {
            abort(404); //error 404 (No encontrado)
        }

        return view('deportes.show', compact('deporte'));
    }

    public function edit(Deporte $deporte)
    {
        // Autoriza la edición usando la Policy (retorna 403 si no está autorizado)
        $this->authorize('update', $deporte);

        return view('deportes.edit', compact('deporte'));
    }

    public function update(Request $request, Deporte $deporte)
    {
        // Autoriza la actualización usando la Policy
        $this->authorize('update', $deporte);

        $request->validate([
            'titulo'      => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'contenido'   => 'required|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $deporte->imagen = $path;
        }
        $deporte->titulo      = $request->titulo;
        $deporte->descripcion = $request->descripcion;
        $deporte->contenido   = $request->contenido;
        $deporte->status      = 'pending'; // Vuelve a revisión
        $deporte->save();

        return redirect()->route('deportes.index');
    }

    public function destroy(Deporte $deporte)
    {
        // Autoriza la eliminación usando la Policy
        $this->authorize('delete', $deporte);

        $deporte->delete();

        return back();
    }

    public function aprobar(Deporte $deporte)
    {
        // Autoriza la revisión usando la Policy
        $this->authorize('review', $deporte);

        $deporte->status = 'approved';
        $deporte->save();

        return back();
    }

    public function rechazar(Deporte $deporte)
    {
        // Autoriza la revisión usando la Policy
        $this->authorize('review', $deporte);

        $deporte->status = 'rejected';
        $deporte->save();

        return back();
    }
}
