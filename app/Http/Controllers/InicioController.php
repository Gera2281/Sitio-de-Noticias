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
        $deportes = Deporte::where('status', 'approved')->latest()->take(3)->get();
        $tecnologia = Tecnologia::where('status', 'approved')->latest()->take(3)->get();
        $locales = Local::where('status', 'approved')->latest()->take(3)->get();
        $internacionales = Internacional::where('status', 'approved')->latest()->take(3)->get();
        $clima = Clima::where('status', 'approved')->latest()->take(3)->get();

        return view('Inicio', compact('deportes', 'tecnologia', 'locales', 'internacionales', 'clima'));
    }
}
