@extends('layouts.base')
@section('titulo', 'Editar Noticia - Internacionales')

@section('contenido')
<div class="container mt-4" style="max-width: 700px;">

    <div class="alert alert-warning d-flex align-items-center gap-2 mb-4" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill flex-shrink-0" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
        </svg>
        <div>
            <strong>Noticia rechazada.</strong> Realiza los cambios necesarios y vuelve a enviarla a revision.
        </div>
    </div>

    <h2 class="mb-4">Editar noticia de Internacionales</h2>

    <form action="{{ route('internacionales.update', $internacional) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            @if($internacional->imagen)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $internacional->imagen) }}" alt="Imagen actual" class="img-thumbnail" style="max-height: 200px;">
                    <p class="text-muted small mt-1">Imagen actual. Sube una nueva para reemplazarla.</p>
                </div>
            @endif
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="titulo" class="form-label">Titulo</label>
            <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                   id="titulo" name="titulo" value="{{ old('titulo', $internacional->titulo) }}">
            @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripcion</label>
            <input type="text" class="form-control @error('descripcion') is-invalid @enderror"
                   id="descripcion" name="descripcion" value="{{ old('descripcion', $internacional->descripcion) }}">
            @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea class="form-control @error('contenido') is-invalid @enderror"
                      id="contenido" name="contenido" rows="6">{{ old('contenido', $internacional->contenido) }}</textarea>
            @error('contenido') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar y reenviar a revision</button>
            <a href="{{ route('internacionales.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
