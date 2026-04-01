@extends('layouts.base')

@section('titulo', 'Internacionales - ' . $internacional->titulo)

@section('contenido')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $internacional->titulo }}</h1>
            <p class="text-muted">Publicado el {{ $internacional->created_at->format('d/m/Y') }} por {{ $internacional->user->name ?? 'Anónimo' }}</p>
            @if($internacional->imagen)
                <img src="{{ asset('storage/' . $internacional->imagen) }}" alt="{{ $internacional->titulo }}" class="img-fluid mb-3">
            @endif
            <p class="lead">{{ $internacional->descripcion }}</p>
            <div>
                {!! nl2br(e($internacional->contenido)) !!}
            </div>
        </div>
        <div class="col-md-4">
            <!-- Sidebar opcional -->
        </div>
    </div>
    <a href="{{ route('internacionales.index') }}" class="btn btn-secondary mt-3">Volver a Internacionales</a>
</div>
@endsection
