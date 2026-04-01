@extends('layouts.base')

@section('titulo', 'Deportes - ' . $deporte->titulo)

@section('contenido')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $deporte->titulo }}</h1>
            <p class="text-muted">Publicado el {{ $deporte->created_at->format('d/m/Y') }} por {{ $deporte->user->name ?? 'Anónimo' }}</p>
            @if($deporte->imagen)
                <img src="{{ asset('storage/' . $deporte->imagen) }}" alt="{{ $deporte->titulo }}" class="img-fluid mb-3">
            @endif
            <p class="lead">{{ $deporte->descripcion }}</p>
            <div>
                {!! nl2br(e($deporte->contenido)) !!}
            </div>
        </div>
        <div class="col-md-4">
            <!-- Sidebar opcional -->
        </div>
    </div>
    <a href="{{ route('deportes.index') }}" class="btn btn-secondary mt-3">Volver a Deportes</a>
</div>
@endsection