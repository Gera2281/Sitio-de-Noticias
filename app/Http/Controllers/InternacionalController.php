<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Internacional;

class InternacionalController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role == 'revisor') {
                $internacionales = Internacional::where('status', 'pending')->get();
            } elseif ($role == 'editor') {
                $internacionales = Internacional::where('user_id', auth()->id())->orWhere('status', 'approved')->get();
            } else {
                $internacionales = Internacional::where('status', 'approved')->get();
            }
        } else {
            $internacionales = Internacional::where('status', 'approved')->get();
        }

        return view('internacionales.index', compact('internacionales'));
    }

    public function create()
    {
        return view('internacionales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'      => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'contenido'   => 'required|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
        ]);

        $internacional = new Internacional();
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $internacional->imagen = $path;
        }
        $internacional->titulo      = $request->titulo;
        $internacional->descripcion = $request->descripcion;
        $internacional->contenido   = $request->contenido;
        $internacional->user_id     = auth()->id();
        $internacional->status      = 'pending';
        $internacional->save();

        return redirect()->route('internacionales.index');
    }

    public function show(Internacional $internacional)
    {
        if ($internacional->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404);
        }

        return view('internacionales.show', compact('internacional'));
    }

    public function aprobar(Internacional $internacional)
    {
        $internacional->status = 'approved';
        $internacional->save();

        return back();
    }

    public function rechazar(Internacional $internacional)
    {
        $internacional->status = 'rejected';
        $internacional->save();

        return back();
    }
}
