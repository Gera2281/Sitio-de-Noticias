@extends('layouts.base')
@section('titulo', 'Noticias Internacionales')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">ULTIMAS NOTICIAS INTERNACIONALES</h2>
    @if(auth()->check() && auth()->user()->role === 'editor')
        <a href="{{ route('internacionales.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
    @endif
</div>
    <div class="row g-3">
        @foreach ($internacionales as $internacional)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.cardinternacional')
            @slot('image', $internacional->imagen)
            @slot('title', $internacional->titulo)
            @slot('content', $internacional->descripcion)
            @endcomponent
            @if(auth()->check() && auth()->user()->role === 'revisor')
                <form action="{{ route('internacionales.aprobar', $internacional) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-success btn-sm mt-2">Aprobar</button>
                </form>
                <form action="{{ route('internacionales.rechazar', $internacional) }}" method="POST" class="d-inline">
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