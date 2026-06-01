@extends('layouts.base')
@section('titulo', 'Clima')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">ULTIMAS NOTICIAS DEL CLIMA</h2>
    @if(auth()->check() && auth()->user()->role === 'editor')
        <a href="{{ route('clima.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
    @endif
</div>
    <div class="row g-3">
        @foreach ($clima as $item)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.cardclima')
            @slot('image', $item->imagen)
            @slot('title', $item->titulo)
            @slot('content', $item->descripcion)
            @slot('link', route('clima.show', $item))
            @endcomponent
                        @if(auth()->check() && auth()->user()->role === 'revisor')
                @if($item->status === 'pending')
                    <form action="{{ route('clima.aprobar', $item) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm mt-2">Aprobar</button>
                    </form>
                    <form action="{{ route('clima.rechazar', $item) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">Rechazar</button>
                    </form>
                @elseif($item->status === 'approved')
                    <form action="{{ route('clima.destroy', $item) }}" method="POST" class="d-inline mt-2" onsubmit="return confirm('¿Eliminar esta noticia aprobada permanentemente?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">Eliminar</button>
                    </form>
                @endif
            @endif
            @if(auth()->check() && auth()->user()->role === 'editor' && $item->user_id === auth()->id())
                @if($item->status === 'rejected')
                <div class="mt-2 p-2 border border-danger rounded bg-danger bg-opacity-10">
                    <span class="badge bg-danger mb-2">Rechazada</span>
                    <div class="d-flex gap-1">
                        <a href="{{ route('clima.edit', $item) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('clima.destroy', $item) }}" method="POST"
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
