@extends('layouts.base')
@section('titulo', 'Deportes')

@section('contenido')
{{-- Encabezado y botón para crear noticia si es editor --}}
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-3 border-danger pb-2">
    <h2 class="mb-0 fw-bold text-danger text-uppercase">Últimas Noticias Deportivas</h2>
    @if(auth()->check() && auth()->user()->role === 'editor')
        <a href="{{ route('deportes.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
    @endif
</div>

    {{-- Listado de noticias de deportes --}}
    <div class="row g-3">
        @foreach ($deportes as $deporte)
        <div class="col-6 col-md-4 col-lg-3">
            {{-- Componente de la tarjeta de deportes --}}
            @component('layouts.componentes.carddeportes')
            @slot('image', $deporte->imagen)
            @slot('title', $deporte->titulo)
            @slot('content', $deporte->descripcion)
            @slot('link', route('deportes.show', $deporte))
            @endcomponent

            {{-- Acciones para el rol de revisor: Aprobar, Rechazar o Eliminar --}}
            @if(auth()->check() && auth()->user()->role === 'revisor')
                @if($deporte->status === 'pending')
                    <form action="{{ route('deportes.aprobar', $deporte) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm mt-2">Aprobar</button>
                    </form>
                    <form action="{{ route('deportes.rechazar', $deporte) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">Rechazar</button>
                    </form>
                @elseif($deporte->status === 'approved')
                    <form action="{{ route('deportes.destroy', $deporte) }}" method="POST" class="d-inline mt-2" onsubmit="return confirm('¿Eliminar esta noticia aprobada permanentemente?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">Eliminar</button>
                    </form>
                @endif
            @endif

            {{-- Acciones para el autor editor si la noticia fue rechazada: Editar o Eliminar --}}
            @if(auth()->check() && auth()->user()->role === 'editor' && $deporte->user_id === auth()->id())
                @if($deporte->status === 'rejected')
                <div class="mt-2 p-2 border border-danger rounded bg-danger bg-opacity-10">
                    <span class="badge bg-danger mb-2">Rechazada</span>
                    <div class="d-flex gap-1">
                        <a href="{{ route('deportes.edit', $deporte) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('deportes.destroy', $deporte) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta noticia permanentemente?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </div>
                </div>
                @endif
            @endif
        </div>
        @endforeach
    </div>
</div>
{{-- Paginación --}}
@endsection

