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
        $deportes = Deporte::all();
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
        $deporte->save();

        return redirect()->route('deportes.index');
    }

    public function tecnologia()
    {
        $tecnologia = Tecnologia::all();
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
        $tecnologia->save();

        return redirect()->route('tecnologia.index');
    }

    public function internacionales()
    {
        $internacionales = Internacional::all();
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
        $internacional->save();

        return redirect()->route('internacionales.index');
    }

    public function clima()
    {
        $clima = Clima::all();
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
        $clima->save();

        return redirect()->route('clima.index');
    }

    public function locales()   
    {
        $locales = Local::all();
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
        $local->save();

        return redirect()->route('locales.index');
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
