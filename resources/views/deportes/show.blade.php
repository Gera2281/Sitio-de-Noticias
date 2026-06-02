@extends('layouts.base')

@section('titulo', 'Deportes - ' . $deporte->titulo)

@section('contenido')
<div class="container mt-4">

    {{-- Título y meta --}}
    <h1>{{ $deporte->titulo }}</h1>
    <p class="text-muted">Publicado el {{ $deporte->created_at->format('d/m/Y') }} por {{ $deporte->user->name ?? 'Anónimo' }}</p>

    {{-- Imagen izquierda + descripción derecha --}}
    <div class="row mb-4">
        @if($deporte->imagen)
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $deporte->imagen) }}" alt="{{ $deporte->titulo }}" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-6 d-flex align-items-center">
            <p class="lead">{{ $deporte->descripcion }}</p>
        </div>
        @else
        <div class="col-12">
            <p class="lead">{{ $deporte->descripcion }}</p>
        </div>
        @endif
    </div>

    {{-- Contenido completo debajo --}}
    <div class="row">
        <div class="col-12">
            <hr>
            <div class="mt-3">
                {!! nl2br(e($deporte->contenido)) !!}
            </div>
        </div>
    </div>

    <a href="{{ route('deportes.index') }}" class="btn btn-secondary mt-4">Volver a Deportes</a>
</div>
@endsection