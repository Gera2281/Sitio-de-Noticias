@extends('layouts.base')

@section('titulo', 'Deportes')

@section('contenido')
    <h2 class="text-center mb-4">Nueva noticia</h2>
    <div class="container mt-4">
        <form action="{{ route('agregarDeporte') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="text" class="form-control" id="imagen" name="imagen">
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion">
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
@endsection