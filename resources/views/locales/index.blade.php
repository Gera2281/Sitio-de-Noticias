@extends('layouts.base')
@section('titulo', 'Noticias Locales')

@section('contenido')
{{-- Encabezado y botón para crear noticia si es editor --}}
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-3 border-success pb-2">
    <h2 class="mb-0 fw-bold text-success text-uppercase">Últimas Noticias Locales</h2>
    @if(auth()->check() && auth()->user()->role === 'editor')
        <a href="{{ route('locales.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
    @endif
</div>

    {{-- Listado de noticias locales --}}
    <div class="row g-3">
        @foreach ($locales as $local)
        <div class="col-6 col-md-4 col-lg-3">
            {{-- Componente de la tarjeta de local --}}
            @component('layouts.componentes.cardlocal')
            @slot('image', $local->imagen)
            @slot('title', $local->titulo)
            @slot('content', $local->descripcion)
            @slot('link', route('locales.show', $local))
            @endcomponent

            {{-- Acciones para el rol de revisor: Aprobar, Rechazar o Eliminar --}}
            @if(auth()->check() && auth()->user()->role === 'revisor')
                @if($local->status === 'pending')
                    <form action="{{ route('locales.aprobar', $local) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm mt-2">Aprobar</button>
                    </form>
                    <form action="{{ route('locales.rechazar', $local) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">Rechazar</button>
                    </form>
                @elseif($local->status === 'approved')
                    <form action="{{ route('locales.destroy', $local) }}" method="POST" class="d-inline mt-2" onsubmit="return confirm('¿Eliminar esta noticia aprobada permanentemente?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">Eliminar</button>
                    </form>
                @endif
            @endif

            {{-- Acciones para el autor editor si la noticia fue rechazada: Editar o Eliminar --}}
            @if(auth()->check() && auth()->user()->role === 'editor' && $local->user_id === auth()->id())
                @if($local->status === 'rejected')
                <div class="mt-2 p-2 border border-danger rounded bg-danger bg-opacity-10">
                    <span class="badge bg-danger mb-2">Rechazada</span>
                    <div class="d-flex gap-1">
                        <a href="{{ route('locales.edit', $local) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('locales.destroy', $local) }}" method="POST"
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
@endsection
