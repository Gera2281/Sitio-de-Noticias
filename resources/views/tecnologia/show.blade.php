@extends('layouts.base')

@section('titulo', 'Tecnología - ' . $tecnologia->titulo)

@section('contenido')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $tecnologia->titulo }}</h1>
            <p class="text-muted">Publicado el {{ $tecnologia->created_at->format('d/m/Y') }} por {{ $tecnologia->user->name ?? 'Anónimo' }}</p>
            @if($tecnologia->imagen)
                <img src="{{ asset('storage/' . $tecnologia->imagen) }}" alt="{{ $tecnologia->titulo }}" class="img-fluid mb-3">
            @endif
            <p class="lead">{{ $tecnologia->descripcion }}</p>
            <div>
                {!! nl2br(e($tecnologia->contenido)) !!}
            </div>
        </div>
        <div class="col-md-4">
            <!-- Sidebar opcional -->
        </div>
    </div>
    <a href="{{ route('tecnologia.index') }}" class="btn btn-secondary mt-3">Volver a Tecnología</a>
</div>
@endsection
