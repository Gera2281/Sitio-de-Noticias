@extends('layouts.base')
@section('titulo', 'Deportes')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">ULTIMAS NOTICIAS DEPORTIVAS</h2>
    @if(auth()->check() && auth()->user()->role === 'editor')
        <a href="{{ route('deportes.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
    @endif
</div>
    <div class="row g-3">
        @foreach ($deportes as $deporte)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.carddeportes')
            @slot('image', $deporte->imagen)
            @slot('title', $deporte->titulo)
            @slot('content', $deporte->descripcion)
            @slot('link', route('deportes.show', $deporte))
            @endcomponent
            @if(auth()->check() && auth()->user()->role === 'revisor')
                <form action="{{ route('deportes.aprobar', $deporte) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-sm mt-2">Aprobar</button>
                </form>
                <form action="{{ route('deportes.rechazar', $deporte) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger btn-sm mt-2">Rechazar</button>
                </form>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection