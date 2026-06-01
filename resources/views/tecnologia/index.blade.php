@extends('layouts.base')
@section('titulo', 'Tecnologia')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">ULTIMAS NOTICIAS TECNOLOGICAS</h2>
    @if(auth()->check() && auth()->user()->role === 'editor')
        <a href="{{ route('tecnologia.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
    @endif
</div>
    <div class="row g-3">
        @foreach ($tecnologia as $tecnologica)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.cardtecnologia')
            @slot('image', $tecnologica->imagen)
            @slot('title', $tecnologica->titulo)
            @slot('content', $tecnologica->descripcion)
            @slot('link', route('tecnologia.show', $tecnologica))
            @endcomponent
                        @if(auth()->check() && auth()->user()->role === 'revisor')
                @if($tecnologica->status === 'pending')
                    <form action="{{ route('tecnologia.aprobar', $tecnologica) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm mt-2">Aprobar</button>
                    </form>
                    <form action="{{ route('tecnologia.rechazar', $tecnologica) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">Rechazar</button>
                    </form>
                @elseif($tecnologica->status === 'approved')
                    <form action="{{ route('tecnologia.destroy', $tecnologica) }}" method="POST" class="d-inline mt-2" onsubmit="return confirm('¿Eliminar esta noticia aprobada permanentemente?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">Eliminar</button>
                    </form>
                @endif
            @endif
            @if(auth()->check() && auth()->user()->role === 'editor' && $tecnologica->user_id === auth()->id())
                @if($tecnologica->status === 'rejected')
                <div class="mt-2 p-2 border border-danger rounded bg-danger bg-opacity-10">
                    <span class="badge bg-danger mb-2">Rechazada</span>
                    <div class="d-flex gap-1">
                        <a href="{{ route('tecnologia.edit', $tecnologica) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('tecnologia.destroy', $tecnologica) }}" method="POST"
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
