@extends('layouts.base')
@section('titulo', 'Deportes')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">ULTIMAS NOTICIAS DEPORTIVAS</h2>
    <a href="{{ route('deportes.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
</div>
    <div class="row g-3">
        @foreach ($deportes as $deporte)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.carddeportes')
            @slot('image', $deporte->imagen)
            @slot('title', $deporte->titulo)
            @slot('content', $deporte->descripcion)
            @endcomponent
        </div>
        @endforeach
    </div>
</div>
@endsection