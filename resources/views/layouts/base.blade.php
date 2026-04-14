<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .news-card-link { display: block; }
        .news-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.18);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 280px;
        }
        .news-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.28);
        }
        .news-card-img {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            position: relative;
            transition: transform 0.4s ease;
            background-image: var(--card-bg); /* Usamos variable para evitar errores de sintaxis en el HTML */
        }
        .news-card:hover .news-card-img { transform: scale(1.04); }
        .news-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(10,10,20,0.92) 40%, rgba(10,10,20,0.25) 100%);
            border-radius: 12px;
        }
        .news-card-body {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 16px;
        }
        .news-card-category {
            display: inline-block;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 2px 8px;
            border-radius: 4px;
            margin-bottom: 6px;
            background: #e63946;
        }
        /* Colores por categoría */
        .news-cat-tecnologia { background: #0077b6; }
        .news-cat-inter { background: #6a0572; }
        .news-cat-clima { background: #00b4d8; }
        .news-cat-local { background: #2d6a4f; }

        .news-card-title {
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.35;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2; /* Propiedad estándar corregida */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .news-card-text {
            color: rgba(255,255,255,0.75);
            font-size: 0.78rem;
            line-height: 1.4;
            margin-bottom: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2; /* Propiedad estándar corregida */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body>

<div class="container" style="margin-top:70px;">
    @include('layouts.partials.menu')
        @yield('contenido')

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>