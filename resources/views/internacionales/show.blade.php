@extends('layouts.base')

@section('titulo', 'Internacionales - ' . $internacional->titulo)

@section('contenido')
<div class="container mt-4">

    {{-- Título y meta --}}
    <h1>{{ $internacional->titulo }}</h1>
    <p class="text-muted">Publicado el {{ $internacional->created_at->format('d/m/Y') }} por {{ $internacional->user->name ?? 'Anónimo' }}</p>

    {{-- Fila superior: imagen izquierda + descripción derecha --}}
    <div class="row mb-4">
        @if($internacional->imagen)
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $internacional->imagen) }}" alt="{{ $internacional->titulo }}" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-6 d-flex align-items-center">
            <p class="lead">{{ $internacional->descripcion }}</p>
        </div>
        @else
        <div class="col-12">
            <p class="lead">{{ $internacional->descripcion }}</p>
        </div>
        @endif
    </div>

    {{-- Contenido completo debajo --}}
    <div class="row">
        <div class="col-12">
            <hr>
            <div class="mt-3">
                {!! nl2br(e($internacional->contenido)) !!}
            </div>
        </div>
    </div>

    <a href="{{ route('internacionales.index') }}" class="btn btn-secondary mt-4">Volver a Internacionales</a>
</div>
@endsection
