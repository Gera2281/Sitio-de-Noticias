<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Local;

class LocalController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role == 'revisor') {
                $locales = Local::whereIn('status', ['pending', 'approved'])->get();
            } elseif ($role == 'editor') {
                $locales = Local::where('user_id', auth()->id())->orWhere('status', 'approved')->get();
            } else {
                $locales = Local::where('status', 'approved')->get();
            }
        } else {
            $locales = Local::where('status', 'approved')->get();
        }

        return view('locales.index', compact('locales'));
    }

    public function create()
    {
        return view('locales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'      => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'contenido'   => 'required|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
        ]);

        $local = new Local();
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $local->imagen = $path;
        }
        $local->titulo      = $request->titulo;
        $local->descripcion = $request->descripcion;
        $local->contenido   = $request->contenido;
        $local->user_id     = auth()->id();
        $local->status      = 'pending';
        $local->save();

        return redirect()->route('locales.index');
    }

    public function show(Local $local)
    {
        if ($local->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404);
        }

        return view('locales.show', compact('local'));
    }

    public function edit(Local $local)
    {
        if ($local->status !== 'rejected' || $local->user_id !== auth()->id()) {
            abort(403);
        }

        return view('locales.edit', compact('local'));
    }

    public function update(Request $request, Local $local)
    {
        if ($local->status !== 'rejected' || $local->user_id !== auth()->id()) {
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
            $local->imagen = $path;
        }
        $local->titulo      = $request->titulo;
        $local->descripcion = $request->descripcion;
        $local->contenido   = $request->contenido;
        $local->status      = 'pending';
        $local->save();

        return redirect()->route('locales.index');
    }

    public function destroy(Local $local)
    {
        $user = auth()->user();
        $isEditorOwner = $user->role === 'editor' && $local->user_id === $user->id && $local->status === 'rejected';
        $isRevisor = $user->role === 'revisor' && $local->status === 'approved';

        if (!$isEditorOwner && !$isRevisor) {
            abort(403);
        }

        $local->delete();

        return back();
    }

    public function aprobar(Local $local)
    {
        $local->status = 'approved';
        $local->save();

        return back();
    }

    public function rechazar(Local $local)
    {
        $local->status = 'rejected';
        $local->save();

        return back();
    }
}

