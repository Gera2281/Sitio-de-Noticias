@extends('layouts.base')

@section('titulo', 'Locales - ' . $local->titulo)

@section('contenido')
<div class="container mt-4">

    {{-- Título y meta --}}
    <h1>{{ $local->titulo }}</h1>
    <p class="text-muted">Publicado el {{ $local->created_at->format('d/m/Y') }} por {{ $local->user->name ?? 'Anónimo' }}</p>

    {{-- Fila superior: imagen izquierda + descripción derecha --}}
    <div class="row mb-4">
        @if($local->imagen)
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $local->imagen) }}" alt="{{ $local->titulo }}" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-6 d-flex align-items-center">
            <p class="lead">{{ $local->descripcion }}</p>
        </div>
        @else
        <div class="col-12">
            <p class="lead">{{ $local->descripcion }}</p>
        </div>
        @endif
    </div>

    {{-- Contenido completo debajo --}}
    <div class="row">
        <div class="col-12">
            <hr>
            <div class="mt-3">
                {!! nl2br(e($local->contenido)) !!}
            </div>
        </div>
    </div>

    <a href="{{ route('locales.index') }}" class="btn btn-secondary mt-4">Volver a Locales</a>
</div>
@endsection
