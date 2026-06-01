<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clima;

class ClimaController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role == 'revisor') {
                $clima = Clima::where('status', 'pending')->get();
            } elseif ($role == 'editor') {
                $clima = Clima::where('user_id', auth()->id())->orWhere('status', 'approved')->get();
            } else {
                $clima = Clima::where('status', 'approved')->get();
            }
        } else {
            $clima = Clima::where('status', 'approved')->get();
        }

        return view('clima.index', compact('clima'));
    }

    public function create()
    {
        return view('clima.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'      => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'contenido'   => 'required|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
        ]);

        $clima = new Clima();
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $clima->imagen = $path;
        }
        $clima->titulo      = $request->titulo;
        $clima->descripcion = $request->descripcion;
        $clima->contenido   = $request->contenido;
        $clima->user_id     = auth()->id();
        $clima->status      = 'pending';
        $clima->save();

        return redirect()->route('clima.index');
    }

    public function show(Clima $clima)
    {
        if ($clima->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404);
        }

        return view('clima.show', compact('clima'));
    }

    public function aprobar(Clima $clima)
    {
        $clima->status = 'approved';
        $clima->save();

        return back();
    }

    public function rechazar(Clima $clima)
    {
        $clima->status = 'rejected';
        $clima->save();

        return back();
    }
}
