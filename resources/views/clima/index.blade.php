@extends('layouts.base')
@section('titulo', 'Clima')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">ULTIMAS NOTICIAS DEL CLIMA</h2>
    <a href="{{ route('clima.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
</div>
    <div class="row g-3">
        @foreach ($clima as $clima)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.cardclima')
            @slot('image', $clima->imagen)
            @slot('title', $clima->titulo)
            @slot('content', $clima->descripcion)
            @endcomponent
        </div>
        @endforeach
    </div>
</div>
@endsection