<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\Producto;
use App\Models\Deporte;
use App\Models\Tecnologia;
use App\Models\Internacional;
use App\Models\Clima;
use App\Models\Local;

class TareaController
{
    public function inicio()
    {
        return view('Inicio');
    }

    public function deportes()
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role == 'revisor') {
                $deportes = Deporte::where('status', 'pending')->get();
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

    public function createDeporte()   
    {
        return view('deportes.create');
    }

    public function agregarDeporte(Request $request)
    {
        $deporte = new Deporte();
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $deporte->imagen = $path;
        }
        $deporte->titulo = $request->titulo;
        $deporte->descripcion = $request->descripcion;
        $deporte->contenido = $request->contenido;
        $deporte->user_id = auth()->id();
        $deporte->status = 'pending';
        $deporte->save();

        return redirect()->route('deportes.index');
    }

    public function showDeporte(Deporte $deporte)
    {
        // Solo mostrar si está aprobado o si el usuario es editor/revisor
        if ($deporte->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404);
        }
        return view('deportes.show', compact('deporte'));
    }

    public function tecnologia()
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

    public function createTecnologia()   
    {
        return view('tecnologia.create');
    }

    public function agregarTecnologia(Request $request)
    {
        $tecnologia = new Tecnologia();
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $tecnologia->imagen = $path;
        }
        $tecnologia->titulo = $request->titulo;
        $tecnologia->descripcion = $request->descripcion;
        $tecnologia->contenido = $request->contenido;
        $tecnologia->user_id = auth()->id();
        $tecnologia->status = 'pending';
        $tecnologia->save();

        return redirect()->route('tecnologia.index');
    }

    public function showTecnologia(Tecnologia $tecnologia)
    {
        if ($tecnologia->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404);
        }
        return view('tecnologia.show', compact('tecnologia'));
    }

    public function internacionales()
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

    public function createInternacional()   
    {
        return view('internacionales.create');
    }

    public function agregarInternacional(Request $request)
    {
        $internacional = new Internacional();
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $internacional->imagen = $path;
        }
        $internacional->titulo = $request->titulo;
        $internacional->descripcion = $request->descripcion;
        $internacional->contenido = $request->contenido;
        $internacional->user_id = auth()->id();
        $internacional->status = 'pending';
        $internacional->save();

        return redirect()->route('internacionales.index');
    }

    public function showInternacional(Internacional $internacional)
    {
        if ($internacional->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404);
        }
        return view('internacionales.show', compact('internacional'));
    }

    public function clima()
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

    public function createClima()   
    {
        return view('clima.create');
    }

    public function agregarClima(Request $request)
    {
        $clima = new Clima();
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $clima->imagen = $path;
        }
        $clima->titulo = $request->titulo;
        $clima->descripcion = $request->descripcion;
        $clima->contenido = $request->contenido;
        $clima->user_id = auth()->id();
        $clima->status = 'pending';
        $clima->save();

        return redirect()->route('clima.index');
    }

    public function showClima(Clima $clima)
    {
        if ($clima->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404);
        }
        return view('clima.show', compact('clima'));
    }

    public function locales()   
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role == 'revisor') {
                $locales = Local::where('status', 'pending')->get();
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

    public function createLocal()   
    {
        return view('locales.create');
    }

    public function agregarLocal(Request $request)
    {
        $local = new Local();
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $local->imagen = $path;
        }
        $local->titulo = $request->titulo;
        $local->descripcion = $request->descripcion;
        $local->contenido = $request->contenido;
        $local->user_id = auth()->id();
        $local->status = 'pending';
        $local->save();

        return redirect()->route('locales.index');
    }

    public function showLocal(Local $local)
    {
        if ($local->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'editor' && auth()->user()->role !== 'revisor'))) {
            abort(404);
        }
        return view('locales.show', compact('local'));
    }

    // Revisor actions
    public function aprobarDeporte(Deporte $deporte)
    {
        $deporte->status = 'approved';
        $deporte->save();

        return back();
    }

    public function rechazarDeporte(Deporte $deporte)
    {
        $deporte->status = 'rejected';
        $deporte->save();

        return back();
    }

    public function aprobarTecnologia(Tecnologia $tecnologia)
    {
        $tecnologia->status = 'approved';
        $tecnologia->save();

        return back();
    }

    public function rechazarTecnologia(Tecnologia $tecnologia)
    {
        $tecnologia->status = 'rejected';
        $tecnologia->save();

        return back();
    }

    public function aprobarInternacional(Internacional $internacional)
    {
        $internacional->status = 'approved';
        $internacional->save();

        return back();
    }

    public function rechazarInternacional(Internacional $internacional)
    {
        $internacional->status = 'rejected';
        $internacional->save();

        return back();
    }

    public function aprobarClima(Clima $clima)
    {
        $clima->status = 'approved';
        $clima->save();

        return back();
    }

    public function rechazarClima(Clima $clima)
    {
        $clima->status = 'rejected';
        $clima->save();

        return back();
    }

    public function aprobarLocal(Local $local)
    {
        $local->status = 'approved';
        $local->save();

        return back();
    }

    public function rechazarLocal(Local $local)
    {
        $local->status = 'rejected';
        $local->save();

        return back();
    }

    public function productos()
    {
        $productos = Producto::all();
        return view('layouts.partials.productos', compact('productos'));
    }

    public function createP()   
    {
        return view('productos.create');
    }

    public function storeP(Request $request)
    {
        $producto = new Producto();
        $producto->imagen = $request->imagen;
        $producto->titulo = $request->titulo;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->save();

        return redirect()->route('productos');
    }

    public function tareas()
    {
        $tareas = Tarea::all();
        return view('tareas.index', compact('tareas'));
    }

    public function create()
    {
        return view('tareas.create');
    }

    public function store(Request $request)
    {
        $tarea = new Tarea();
        $tarea->nombre = $request->nombre;
        $tarea->descripcion = $request->descripcion;
        $tarea->atendido = $request->has('atendido') ? 1 : 0;
        $tarea->entrega = $request->entrega;
        $tarea->save();

        return redirect()->route('tareas');
    }
}
