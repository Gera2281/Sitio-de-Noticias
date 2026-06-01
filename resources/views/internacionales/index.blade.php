@extends('layouts.base')
@section('titulo', 'Noticias Internacionales')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">ULTIMAS NOTICIAS INTERNACIONALES</h2>
    @if(auth()->check() && auth()->user()->role === 'editor')
        <a href="{{ route('internacionales.create') }}" class="btn btn-primary mb-2 ">Crear Noticia</a>
    @endif
</div>
    <div class="row g-3">
        @foreach ($internacionales as $internacional)
        <div class="col-6 col-md-4 col-lg-3">
            @component('layouts.componentes.cardinternacional')
            @slot('image', $internacional->imagen)
            @slot('title', $internacional->titulo)
            @slot('content', $internacional->descripcion)
            @slot('link', route('internacionales.show', $internacional))
            @endcomponent
                        @if(auth()->check() && auth()->user()->role === 'revisor')
                @if($internacional->status === 'pending')
                    <form action="{{ route('internacionales.aprobar', $internacional) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm mt-2">Aprobar</button>
                    </form>
                    <form action="{{ route('internacionales.rechazar', $internacional) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">Rechazar</button>
                    </form>
                @elseif($internacional->status === 'approved')
                    <form action="{{ route('internacionales.destroy', $internacional) }}" method="POST" class="d-inline mt-2" onsubmit="return confirm('¿Eliminar esta noticia aprobada permanentemente?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">Eliminar</button>
                    </form>
                @endif
            @endif
            @if(auth()->check() && auth()->user()->role === 'editor' && $internacional->user_id === auth()->id())
                @if($internacional->status === 'rejected')
                <div class="mt-2 p-2 border border-danger rounded bg-danger bg-opacity-10">
                    <span class="badge bg-danger mb-2">Rechazada</span>
                    <div class="d-flex gap-1">
                        <a href="{{ route('internacionales.edit', $internacional) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('internacionales.destroy', $internacional) }}" method="POST"
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
