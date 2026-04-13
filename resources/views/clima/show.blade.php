@extends('layouts.base')

@section('titulo', 'Clima - ' . $clima->titulo)

@section('contenido')
<div class="container mt-4">

    {{-- Título y meta --}}
    <h1>{{ $clima->titulo }}</h1>
    <p class="text-muted">Publicado el {{ $clima->created_at->format('d/m/Y') }} por {{ $clima->user->name ?? 'Anónimo' }}</p>

    {{-- Fila superior: imagen izquierda + descripción derecha --}}
    <div class="row mb-4">
        @if($clima->imagen)
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $clima->imagen) }}" alt="{{ $clima->titulo }}" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-6 d-flex align-items-center">
            <p class="lead">{{ $clima->descripcion }}</p>
        </div>
        @else
        <div class="col-12">
            <p class="lead">{{ $clima->descripcion }}</p>
        </div>
        @endif
    </div>

    {{-- Contenido completo debajo --}}
    <div class="row">
        <div class="col-12">
            <hr>
            <div class="mt-3">
                {!! nl2br(e($clima->contenido)) !!}
            </div>
        </div>
    </div>

    <a href="{{ route('clima.index') }}" class="btn btn-secondary mt-4">Volver a Clima</a>
</div>
@endsection
