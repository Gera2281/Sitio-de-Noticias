@extends('layouts.base')

@section('titulo', 'Inicio')

@section('contenido')
<div id="myCarousel" class="carousel slide carousel-fade mb-5" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="5" aria-label="Slide 6"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('img/LogoN.png') }}" class="d-block w-100" alt="Inicio">
            <div class="container">
                <div class="carousel-caption text-white">
                    <span class="carousel-badge carousel-badge-inicio">Bienvenido</span>
                    <h1>Tu fuente de noticias</h1>
                    <p>Aquí encontrarás las noticias más importantes. Elige la sección que desees ver.</p>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <img src="{{ asset('img/deporte.png') }}" class="d-block w-100" alt="Deporte">
            <div class="container">
                <div class="carousel-caption">
                    <span class="carousel-badge carousel-badge-deportes">Deportes</span>
                    <h1>Deportes</h1>
                    <p>Las noticias más recientes del mundo deportivo</p>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <img src="{{ asset('img/tecno.png') }}" class="d-block w-100" alt="Tecnologia">
            <div class="container">
                <div class="carousel-caption text-white">
                    <span class="carousel-badge carousel-badge-tecnologia">Tecnología</span>
                    <h1>Tecnología</h1>
                    <p>Aquí encontrarás las noticias más recientes acerca de la tecnología</p>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <img src="{{ asset('img/inter.png') }}" class="d-block w-100" alt="Internacionales">
            <div class="container">
                <div class="carousel-caption">
                    <span class="carousel-badge carousel-badge-inter">Internacional</span>
                    <h1>Noticias Internacionales</h1>
                    <p>Las noticias más importantes del mundo</p>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <img src="{{ asset('img/clima.png') }}" class="d-block w-100" alt="Clima">
            <div class="container">
                <div class="carousel-caption">
                    <span class="carousel-badge carousel-badge-clima">Clima</span>
                    <h1>Clima</h1>
                    <p>Noticias más recientes acerca del clima</p>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <img src="{{ asset('img/locales.png') }}" class="d-block w-100" alt="Locales">
            <div class="container">
                <div class="carousel-caption">
                    <span class="carousel-badge carousel-badge-locales">Locales</span>
                    <h1>Locales</h1>
                    <p>Las noticias más recientes cerca de ti</p>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container marketing mt-5">
    {{-- Noticias Deportivas --}}
    <h2 class="text-center mb-4">Deportes</h2>
    <div class="row g-3 mb-5">
        @forelse ($deportes as $deporte)
        <div class="col-6 col-md-4 col-lg-4">
            @component('layouts.componentes.carddeportes')
            @slot('image', $deporte->imagen)
            @slot('title', $deporte->titulo)
            @slot('content', $deporte->descripcion)
            @slot('link', route('deportes.show', $deporte))
            @endcomponent
        </div>
        @empty
        <p class="text-center text-muted">No hay noticias deportivas disponibles.</p>
        @endforelse
    </div>

    <hr class="featurette-divider">

    {{-- Noticias de Tecnología --}}
    <h2 class="text-center mb-4">Tecnología</h2>
    <div class="row g-3 mb-5">
        @forelse ($tecnologia as $tech)
        <div class="col-6 col-md-4 col-lg-4">
            @component('layouts.componentes.cardtecnologia')
            @slot('image', $tech->imagen)
            @slot('title', $tech->titulo)
            @slot('content', $tech->descripcion)
            @slot('link', route('tecnologia.show', $tech))
            @endcomponent
        </div>
        @empty
        <p class="text-center text-muted">No hay noticias de tecnología disponibles.</p>
        @endforelse
    </div>

    <hr class="featurette-divider">

    {{-- Noticias Internacionales --}}
    <h2 class="text-center mb-4">Internacionales</h2>
    <div class="row g-3 mb-5">
        @forelse ($internacionales as $inter)
        <div class="col-6 col-md-4 col-lg-4">
            @component('layouts.componentes.cardinternacional')
            @slot('image', $inter->imagen)
            @slot('title', $inter->titulo)
            @slot('content', $inter->descripcion)
            @slot('link', route('internacionales.show', $inter))
            @endcomponent
        </div>
        @empty
        <p class="text-center text-muted">No hay noticias internacionales disponibles.</p>
        @endforelse
    </div>

    <hr class="featurette-divider">

    {{-- Noticias de Clima --}}
    <h2 class="text-center mb-4">Clima</h2>
    <div class="row g-3 mb-5">
        @forelse ($clima as $cl)
        <div class="col-6 col-md-4 col-lg-4">
            @component('layouts.componentes.cardclima')
            @slot('image', $cl->imagen)
            @slot('title', $cl->titulo)
            @slot('content', $cl->descripcion)
            @slot('link', route('clima.show', $cl))
            @endcomponent
        </div>
        @empty
        <p class="text-center text-muted">No hay noticias de clima disponibles.</p>
        @endforelse
    </div>

    <hr class="featurette-divider">

    {{-- Noticias Locales --}}
    <h2 class="text-center mb-4">Locales</h2>
    <div class="row g-3 mb-5">
        @forelse ($locales as $local)
        <div class="col-6 col-md-4 col-lg-4">
            @component('layouts.componentes.cardlocal')
            @slot('image', $local->imagen)
            @slot('title', $local->titulo)
            @slot('content', $local->descripcion)
            @slot('link', route('locales.show', $local))
            @endcomponent
        </div>
        @empty
        <p class="text-center text-muted">No hay noticias locales disponibles.</p>
        @endforelse
    </div>
</div>
@endsection