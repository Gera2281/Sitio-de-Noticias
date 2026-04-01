@extends('layouts.base')
@section('titulo', 'Clima')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">ULTIMAS NOTICIAS DEL CLIMA</h2>
    @if(auth()->check() && auth()->user()->role === 'editor')
        <a href="{{ route('clima.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
    @endif
</div>
    <div class="row g-3">
        @foreach ($clima as $item)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.cardclima')
            @slot('image', $item->imagen)
            @slot('title', $item->titulo)
            @slot('content', $item->descripcion)
            @endcomponent
            @if(auth()->check() && auth()->user()->role === 'revisor')
                <form action="{{ route('clima.aprobar', $item) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-success btn-sm mt-2">Aprobar</button>
                </form>
                <form action="{{ route('clima.rechazar', $item) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-danger btn-sm mt-2">Rechazar</button>
                </form>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection