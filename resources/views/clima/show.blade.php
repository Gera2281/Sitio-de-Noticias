@extends('layouts.base')

@section('titulo', 'Clima - ' . $clima->titulo)

@section('contenido')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $clima->titulo }}</h1>
            <p class="text-muted">Publicado el {{ $clima->created_at->format('d/m/Y') }} por {{ $clima->user->name ?? 'Anónimo' }}</p>
            @if($clima->imagen)
                <img src="{{ asset('storage/' . $clima->imagen) }}" alt="{{ $clima->titulo }}" class="img-fluid mb-3">
            @endif
            <p class="lead">{{ $clima->descripcion }}</p>
            <div>
                {!! nl2br(e($clima->contenido)) !!}
            </div>
        </div>
        <div class="col-md-4">
            <!-- Sidebar opcional -->
        </div>
    </div>
    <a href="{{ route('clima.index') }}" class="btn btn-secondary mt-3">Volver a Clima</a>
</div>
@endsection
