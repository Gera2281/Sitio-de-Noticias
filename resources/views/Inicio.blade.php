@extends('layouts.base')

@section('titulo', 'Inicio')

@section('contenido')
    <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
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
                <img src="{{ asset('img/LogoN.png') }}" class="d-block w-100" style="height: 600px; object-fit: cover;" alt="Inicio">
                <div class="container">
                    <div class="carousel-caption text-white">
                        <!-- <h1 >Aqui encontraras las noticias mas importantes.</h1> -->
                        <!-- <p >Elige la seccion que desees ver</p> -->
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/deporte.png') }}" class="d-block w-100" style="height: 600px; object-fit: cover;" alt="Deporte">
                    <div class="container">
                        <div class="carousel-caption">
                        <!-- <h1>Deportes</h1> -->
                        <!-- <p>Aqui encontraras las noticias mas recientes acerca del deporte</p> -->
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/tecno.png') }}" class="d-block w-100" style="height: 600px; object-fit: cover;" alt="Tecnologia">
                <div class="container">
                    <div class="carousel-caption text-white">
                        <h1>Tecnologia</h1>
                        <p>Aqui encontraras las noticias mas recientes acerca de la tecnologia</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/inter.png') }}" class="d-block w-100" style="height: 600px; object-fit: cover;" alt="INternacionales">
                <div class="container">
                    <div class="carousel-caption ">
                        <!-- <h1>Noticias internacionales</h1> -->
                        <!-- <p>Las noticias mas importantes del mundo</p> -->
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/clima.png') }}" class="d-block w-100" style="height: 600px; object-fit: cover;" alt="CLima">
                <div class="container">
                    <div class="carousel-caption ">
                        <!-- <h1>Clima</h1> -->
                        <!-- <p>Noticias mas recientes acerca del clima</p> -->
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/locales.png') }}" class="d-block w-100" style="height: 600px; object-fit: cover;" alt="Locales">
                <div class="container">
                    <div class="carousel-caption ">
                        <!-- <h1>Locales</h1> -->
                        <!-- <p>Las noticias mas recientes cerca de ti.</p> -->
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
        <h1 class="text-center mb-5">Noticias Destacadas</h1>
        <div class="row">
            <div class="col-lg-4 text-center">
                <img src="{{ asset('img/deportes1.png') }}" class="card-img-top" width="160" height="210" alt="Chivas">
                <h2 class="fw-normal">Cuenta regresiva</h2>
                <p>así están las selecciones de México, EE.UU. y Canadá a 100 días del Mundial 2026</p>
            </div>
            <div class="col-lg-4 text-center">
                <img src="{{ asset('img/tecnologia1.png') }}" class="card-img-top" width="160" height="210" alt="Logo">
                <h2 class="fw-normal">Gafas inteligentes</h2>
                <p>Mark Zuckerberg presenta las nuevas gafas inteligentes de Meta impulsadas por inteligencia artificial</p>
            </div>
            <div class="col-lg-4 text-center">
                <img src="{{ asset('img/locales1.png') }}" class="card-img-top" width="160" height="210" alt="Deporte">
                <h2 class="fw-normal">Pascua en Tamatan</h2>
                <p>Invitan a recolección de huevos de Pascua en Tamatán.</p>
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette" id="mascota">
            <div class="col-md-7">
                <h2 class="featurette-heading fw-normal lh-1">Localizan barcos de ayuda</h2>
                <p class="lead">Localizan barcos de ayuda desaparecidos con destino a Cuba, dicen autoridades mexicanas</p>
            </div>
            <div class="col-md-5">
                <img src="{{ asset('img/internacional1.png') }}" class="img-fluid mx-auto" width="400" alt="Internacional">
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette" id="musica-detalle">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading fw-normal lh-1">Clima en Victoria</h2>
                <p class="lead">El clima en Victoria presenta condiciones favorables para los residentes.</p>
            </div>
            <div class="col-md-5 order-md-1">
                <img src="{{ asset('img/clima1.png') }}" class="img-fluid mx-auto" width="500" alt="Clima">
            </div>
        </div>
    </div>
@endsection