@extends('layouts.base')

@section('titulo', 'Inicio - Jose Gerardo')

@section('contenido')
    <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/musica.jpeg') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Musica">
                <div class="container">
                    <div class="carousel-caption text-start text-dark">
                        <h1 class="bg-white d-inline-block px-2">Música favorita.</h1>
                        <p class="bg-white d-inline-block px-2">Mi música se basa en ritmo, no tengo un género favorito.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/Deporte.jpeg') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Deporte">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Deporte que practico</h1>
                        <p>El béisbol es mi pasión, me gusta jugarlo con mis amigos.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/logo.png') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Tec">
                <div class="container">
                    <div class="carousel-caption text-end">
                        <h1>ITCV</h1>
                        <p>Estudio Ingeniería en Sistemas Computacionales en el Tec Victoria.</p>
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
        <div class="row">
            <div class="col-lg-4 text-center">
                <img src="{{ asset('img/Chivas.png') }}" class="rounded-circle" width="140" height="140" alt="Chivas">
                <h2 class="fw-normal">Equipo favorito</h2>
                <p>El Guadalajara, el equipo con más historia de México.</p>
            </div>
            <div class="col-lg-4 text-center">
                <img src="{{ asset('img/logo.png') }}" class="rounded-circle" width="140" height="140" alt="Logo">
                <h2 class="fw-normal">Universidad</h2>
                <p>9no semestre en el Instituto Tecnológico de Ciudad Victoria.</p>
            </div>
            <div class="col-lg-4 text-center">
                <img src="{{ asset('img/Deporte.jpeg') }}" class="rounded-circle" width="140" height="140" alt="Deporte">
                <h2 class="fw-normal">Deporte</h2>
                <p>Fan de los Dodgers y jugador de béisbol en mi tiempo libre.</p>
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette" id="mascota">
            <div class="col-md-7">
                <h2 class="featurette-heading fw-normal lh-1">Mi <span class="text-body-secondary">Mascota</span></h2>
                <p class="lead">Mi mascota favorita es Bibi, una perrita Chihuahua muy juguetona.</p>
            </div>
            <div class="col-md-5">
                <img src="{{ asset('img/bibi.jpeg') }}" class="img-fluid mx-auto" width="300" alt="Bibi">
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette" id="musica-detalle">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading fw-normal lh-1">Gustos de <span class="text-body-secondary">Música</span></h2>
                <p class="lead">Disfruto del rock y pop con letras significativas.</p>
            </div>
            <div class="col-md-5 order-md-1">
                <img src="{{ asset('img/musica.jpeg') }}" class="img-fluid mx-auto" width="400" alt="Musica">
            </div>
        </div>
    </div>
@endsection