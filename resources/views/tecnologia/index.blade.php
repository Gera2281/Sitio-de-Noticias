@extends('layouts.base')
@section('titulo', 'Tecnologia')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">ULTIMAS NOTICIAS TECNOLOGICAS</h2>
    <a href="{{ route('tecnologia.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
</div>
    <div class="row g-3">
        @foreach ($tecnologia as $tecnologica)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.cardtecnologia')
            @slot('image', $tecnologica->imagen)
            @slot('title', $tecnologica->titulo)
            @slot('content', $tecnologica->descripcion)
            @endcomponent
        </div>
        @endforeach
    </div>
</div>
@endsection