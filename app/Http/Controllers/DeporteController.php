<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deporte;

class DeporteController extends Controller
{
    public function index()
    {
        if (auth()->check()) {                                  //El usuario inicio sesion
            $role = auth()->user()->role;
            if ($role == 'revisor') {                           // El Revisor ve las noticias pendientes de aprobación y las ya aprobadas
                $deportes = Deporte::whereIn('status', ['pending', 'approved'])->get();
            } elseif ($role == 'editor') {                      //Si el usuario es editor ve sus noticias rechazadas y todas las aprobadas
                $deportes = Deporte::where('user_id', auth()->id())->orWhere('status', 'approved')->get();
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
        $deporte->user_id     = auth()->id();         //Guarda quién la escribió
        $deporte->status      = 'pending';        //Empieza con estado pendiente para que el Revisor la revise
        $deporte->save();

        return redirect()->route('deportes.index');
    }

    public function show(Deporte $deporte)
    {
        // Solo mostrar si esta aprobado o si el usuario es editor/revisor
        if ($deporte->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404); //error 404 (No encontrado)
        }

        return view('deportes.show', compact('deporte'));
    }

    public function edit(Deporte $deporte)
    {
        // Solo el editor dueño puede editar una noticia rechazada
        if ($deporte->status !== 'rejected' || $deporte->user_id !== auth()->id()) {
            abort(403); //error 403 (No autorizado)
        }

        return view('deportes.edit', compact('deporte'));
    }

    public function update(Request $request, Deporte $deporte)
    {
        // Solo el editor dueño puede actualizar una noticia rechazada
        if ($deporte->status !== 'rejected' || $deporte->user_id !== auth()->id()) {
            abort(403); //error 403 (No autorizado)
        }

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

    public function destroy(Deporte $deporte) //El editor puede borrar sus noticias rechazadas y el revisor puede borrar las aprobadas
    {
        $user = auth()->user();
        $isEditorOwner = $user->role === 'editor' && $deporte->user_id === $user->id && $deporte->status === 'rejected';
        $isRevisor = $user->role === 'revisor' && $deporte->status === 'approved';

        if (!$isEditorOwner && !$isRevisor) {
            abort(403);
        }

        $deporte->delete();

        return back();
    }

    public function aprobar(Deporte $deporte) //Lo aprueba el revisor
    {
        $deporte->status = 'approved';
        $deporte->save();

        return back();
    }

    public function rechazar(Deporte $deporte) //Lo rechaza el revisor
    {
        $deporte->status = 'rejected';
        $deporte->save();

        return back();
    }
}
