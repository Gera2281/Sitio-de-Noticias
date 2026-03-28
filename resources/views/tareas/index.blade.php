@extends('layouts.base')

@section('titulo', 'Tareas')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Aqui iran las tareas</h2>
    <a href="{{ route('tareas.create') }}" class="btn btn-primary mb-2 ">Crear tarea</a>
</div>
<div class="container mt-4">
    <table class="table">
        <thead>
            <tr>
                <!--<th>ID</th>-->
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Atendido</th>
                <th>Fecha de entrega</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tareas as $tarea)
            <tr>
                <!--<td>{{ $tarea->id }}</td>-->
                <td>{{ $tarea->nombre }}</td>
                <td>{{ $tarea->descripcion }}</td>
                <td>{{ $tarea->atendido }}</td>
                <td>{{ $tarea->entrega }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection