<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deporte;

class DeporteController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role == 'revisor') {
                $deportes = Deporte::whereIn('status', ['pending', 'approved'])->get();
            } elseif ($role == 'editor') {
                $deportes = Deporte::where('user_id', auth()->id())->orWhere('status', 'approved')->get();
            } else {
                $deportes = Deporte::where('status', 'approved')->get();
            }
        } else {
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
        $request->validate([
            'titulo'      => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'contenido'   => 'required|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
        ]);

        $deporte = new Deporte();
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $deporte->imagen = $path;
        }
        $deporte->titulo      = $request->titulo;
        $deporte->descripcion = $request->descripcion;
        $deporte->contenido   = $request->contenido;
        $deporte->user_id     = auth()->id();
        $deporte->status      = 'pending';
        $deporte->save();

        return redirect()->route('deportes.index');
    }

    public function show(Deporte $deporte)
    {
        // Solo mostrar si estÃ¡ aprobado o si el usuario es editor/revisor
        if ($deporte->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404);
        }

        return view('deportes.show', compact('deporte'));
    }

    public function edit(Deporte $deporte)
    {
        // Solo el editor dueÃ±o puede editar una noticia rechazada
        if ($deporte->status !== 'rejected' || $deporte->user_id !== auth()->id()) {
            abort(403);
        }

        return view('deportes.edit', compact('deporte'));
    }

    public function update(Request $request, Deporte $deporte)
    {
        // Solo el editor dueÃ±o puede actualizar una noticia rechazada
        if ($deporte->status !== 'rejected' || $deporte->user_id !== auth()->id()) {
            abort(403);
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
        $deporte->status      = 'pending'; // Vuelve a revisiÃ³n
        $deporte->save();

        return redirect()->route('deportes.index');
    }

    public function destroy(Deporte $deporte)
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

    public function aprobar(Deporte $deporte)
    {
        $deporte->status = 'approved';
        $deporte->save();

        return back();
    }

    public function rechazar(Deporte $deporte)
    {
        $deporte->status = 'rejected';
        $deporte->save();

        return back();
    }
}

