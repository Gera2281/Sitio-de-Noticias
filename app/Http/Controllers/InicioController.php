<?php

namespace App\Http\Controllers;

use App\Models\Deporte;
use App\Models\Tecnologia;
use App\Models\Internacional;
use App\Models\Clima;
use App\Models\Local;

class InicioController extends Controller
{
    public function index()
    {
        // Obtiene las últimas 3 noticias aprobadas de cada categoría para mostrarlas en la página de inicio
        $deportes = Deporte::where('status', 'approved')->latest()->take(3)->get();
        $tecnologia = Tecnologia::where('status', 'approved')->latest()->take(3)->get();
        $locales = Local::where('status', 'approved')->latest()->take(3)->get();
        $internacionales = Internacional::where('status', 'approved')->latest()->take(3)->get();
        $clima = Clima::where('status', 'approved')->latest()->take(3)->get();

        // Carga la vista de inicio ('Inicio.blade.php') y le pasa todos los listados de noticias
        return view('Inicio', compact('deportes', 'tecnologia', 'locales', 'internacionales', 'clima'));
    }
}
