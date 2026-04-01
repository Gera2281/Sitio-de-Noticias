@extends('layouts.base')

@section('titulo', 'Locales - ' . $local->titulo)

@section('contenido')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $local->titulo }}</h1>
            <p class="text-muted">Publicado el {{ $local->created_at->format('d/m/Y') }} por {{ $local->user->name ?? 'Anónimo' }}</p>
            @if($local->imagen)
                <img src="{{ asset('storage/' . $local->imagen) }}" alt="{{ $local->titulo }}" class="img-fluid mb-3">
            @endif
            <p class="lead">{{ $local->descripcion }}</p>
            <div>
                {!! nl2br(e($local->contenido)) !!}
            </div>
        </div>
        <div class="col-md-4">
            <!-- Sidebar opcional -->
        </div>
    </div>
    <a href="{{ route('locales.index') }}" class="btn btn-secondary mt-3">Volver a Locales</a>
</div>
@endsection
