<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tecnologia;

class TecnologiaController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role == 'revisor') {
                $tecnologia = Tecnologia::where('status', 'pending')->get();
            } elseif ($role == 'editor') {
                $tecnologia = Tecnologia::where('user_id', auth()->id())->orWhere('status', 'approved')->get();
            } else {
                $tecnologia = Tecnologia::where('status', 'approved')->get();
            }
        } else {
            $tecnologia = Tecnologia::where('status', 'approved')->get();
        }

        return view('tecnologia.index', compact('tecnologia'));
    }

    public function create()
    {
        return view('tecnologia.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'      => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'contenido'   => 'required|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
        ]);

        $tecnologia = new Tecnologia();
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $tecnologia->imagen = $path;
        }
        $tecnologia->titulo      = $request->titulo;
        $tecnologia->descripcion = $request->descripcion;
        $tecnologia->contenido   = $request->contenido;
        $tecnologia->user_id     = auth()->id();
        $tecnologia->status      = 'pending';
        $tecnologia->save();

        return redirect()->route('tecnologia.index');
    }

    public function show(Tecnologia $tecnologia)
    {
        if ($tecnologia->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404);
        }

        return view('tecnologia.show', compact('tecnologia'));
    }

    public function aprobar(Tecnologia $tecnologia)
    {
        $tecnologia->status = 'approved';
        $tecnologia->save();

        return back();
    }

    public function rechazar(Tecnologia $tecnologia)
    {
        $tecnologia->status = 'rejected';
        $tecnologia->save();

        return back();
    }
}
