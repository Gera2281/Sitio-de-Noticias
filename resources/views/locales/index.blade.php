@extends('layouts.base')
@section('titulo', 'Noticias Locales')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">ULTIMAS NOTICIAS LOCALES</h2>
    <a href="{{ route('locales.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
</div>
    <div class="row g-3">
        @foreach ($locales as $local)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.cardlocal')
            @slot('image', $local->imagen)
            @slot('title', $local->titulo)
            @slot('content', $local->descripcion)
            @endcomponent
        </div>
        @endforeach
    </div>
</div>
@endsection