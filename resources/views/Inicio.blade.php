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
                <img src="{{ asset('img/musica.jpeg') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Musica">
                <div class="container">
                    <div class="carousel-caption text-white">
                        <h1 >Aqui encontraras las noticias mas importantes.</h1>
                        <p >Elige la seccion que desees ver</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/Deporte.jpeg') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Deporte">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Deportes</h1>
                        <p>Aqui encontraras las noticias mas recientes acerca del deporte</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/logo.png') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Tecnologia">
                <div class="container">
                    <div class="carousel-caption ">
                        <h1>Tecnologia</h1>
                        <p>Aqui encontraras las noticias mas recientes acerca de la tecnologia</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/logo.png') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="INternacionales">
                <div class="container">
                    <div class="carousel-caption ">
                        <h1>Noticias internacionales</h1>
                        <p>Las noticias mas importantes del mundo</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/logo.png') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="CLima">
                <div class="container">
                    <div class="carousel-caption ">
                        <h1>Clima</h1>
                        <p>Noticias mas recientes acerca del clima</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/logo.png') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Locales">
                <div class="container">
                    <div class="carousel-caption ">
                        <h1>Locales</h1>
                        <p>Las noticias mas recientes cerca de ti./p>
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