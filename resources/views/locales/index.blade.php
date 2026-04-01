@extends('layouts.base')
@section('titulo', 'Noticias Locales')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">ULTIMAS NOTICIAS LOCALES</h2>
    @if(auth()->check() && auth()->user()->role === 'editor')
        <a href="{{ route('locales.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
    @endif
</div>
    <div class="row g-3">
        @foreach ($locales as $local)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.cardlocal')
            @slot('image', $local->imagen)
            @slot('title', $local->titulo)
            @slot('content', $local->descripcion)
            @endcomponent
            @if(auth()->check() && auth()->user()->role === 'revisor')
                <form action="{{ route('locales.aprobar', $local) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-success btn-sm mt-2">Aprobar</button>
                </form>
                <form action="{{ route('locales.rechazar', $local) }}" method="POST" class="d-inline">
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