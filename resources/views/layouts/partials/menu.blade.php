<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid justify-content-start">
        <a class="navbar-brand" href="{{ url('/') }}">Noticias en llamas</a>
        <img src="img/Noti.png" alt="Bootstrap" width="35" height="35">
        <div class="ms-4">
            <a class="text-white me-3" href="{{ url('/') }}">Inicio</a>
            <a class="text-white me-3" href="{{ url('/deportes') }}">Deportes</a>
            <a class="text-white me-3" href="{{ url('/tecnologia') }}">Tecnología</a>
            <a class="text-white me-3" href="{{ url('/internacionales') }}">Noticias Internacionales</a>
            <a class="text-white me-3" href="{{ url('/clima') }}">Clima</a>
            <a class="text-white me-3" href="{{ url('/locales') }}">Noticias Locales</a>
        </div>

        <div class="ms-auto text-white">
            @auth
                <span class="me-3">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-outline-light">Cerrar sesión</button>
                </form>
            @endauth
            @guest
                <a class="text-white me-3" href="{{ route('login') }}">Iniciar sesión</a>
                <a class="text-white" href="{{ route('register') }}">Registrarse</a>
            @endguest
        </div>
    </div>
</nav>