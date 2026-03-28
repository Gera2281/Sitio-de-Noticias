@extends('layouts.base')

@section('titulo', 'Nueva tarea')

@section('contenido')
    <h2 class="text-center mb-4">Nueva tarea</h2>
    <div class="container mt-4">
        <form action="{{ route('tareas.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion">
            </div>
            <div class="mb-3">
                <label for="atendido" class="form-label">Atendido</label>
                <input type="checkbox" class="form-check-input" id="atendido" name="atendido">
            </div>
            <div class="mb-3">
                <label for="entrega" class="form-label">Fecha de entrega</label>
                <input type="date" class="form-control" id="entrega" name="entrega">
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
@endsection