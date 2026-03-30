<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\Producto;
use App\Models\Deporte;
use App\Models\Tecnologia;

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
        $deporte->imagen = $request->imagen;
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
        $tecnologia->imagen = $request->imagen;
        $tecnologia->titulo = $request->titulo;
        $tecnologia->descripcion = $request->descripcion;
        $tecnologia->save();

        return redirect()->route('tecnologia.index');
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
