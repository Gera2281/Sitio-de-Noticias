@extends('layouts.base')

@section('titulo', 'Productos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Productos más vendidos</h2>
    <a href="{{ route('productos.createP') }}" class="btn btn-primary mb-2 ">Crear producto</a>
</div>
    <div class="row g-3">
        @foreach ($productos as $producto)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.card')
            @slot('image', $producto->imagen)
            @slot('title', $producto->titulo)
            @slot('content', $producto->descripcion)
            @slot('price', $producto->precio)
            @endcomponent
        </div>
        @endforeach
    </div>
</div>
@endsection