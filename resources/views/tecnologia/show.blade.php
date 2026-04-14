@extends('layouts.base')

@section('titulo', 'Tecnología - ' . $tecnologia->titulo)

@section('contenido')
<div class="container mt-4">

    {{-- Título y meta --}}
    <h1>{{ $tecnologia->titulo }}</h1>
    <p class="text-muted">Publicado el {{ $tecnologia->created_at->format('d/m/Y') }} por {{ $tecnologia->user->name ?? 'Anónimo' }}</p>

    {{-- Fila superior: imagen izquierda + descripción derecha --}}
    <div class="row mb-4">
        @if($tecnologia->imagen)
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $tecnologia->imagen) }}" alt="{{ $tecnologia->titulo }}" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-6 d-flex align-items-center">
            <p class="lead">{{ $tecnologia->descripcion }}</p>
        </div>
        @else
        <div class="col-12">
            <p class="lead">{{ $tecnologia->descripcion }}</p>
        </div>
        @endif
    </div>

    {{-- Contenido completo debajo --}}
    <div class="row">
        <div class="col-12">
            <hr>
            <div class="mt-3">
                {!! nl2br(e($tecnologia->contenido)) !!}
            </div>
        </div>
    </div>

    <a href="{{ route('tecnologia.index') }}" class="btn btn-secondary mt-4">Volver a Tecnología</a>
</div>
@endsection
