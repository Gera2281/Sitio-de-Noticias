<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .news-card-link {
            display: block;
        }

        .news-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.18);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 280px;
        }

        .news-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.28);
        }

        .news-card-img {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            position: relative;
            transition: transform 0.4s ease;
            background-image: var(--card-bg);
            /* Usamos variable para evitar errores de sintaxis en el HTML */
        }

        .news-card:hover .news-card-img {
            transform: scale(1.04);
        }

        .news-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(10, 10, 20, 0.92) 40%, rgba(10, 10, 20, 0.25) 100%);
            border-radius: 12px;
        }

        .news-card-body {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
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
        .news-cat-tecnologia {
            background: #0077b6;
        }

        .news-cat-inter {
            background: #6a0572;
        }

        .news-cat-clima {
            background: #00b4d8;
        }

        .news-cat-local {
            background: #2d6a4f;
        }

        .news-card-title {
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.35;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            /* Propiedad estándar corregida */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-card-text {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.78rem;
            line-height: 1.4;
            margin-bottom: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            /* Propiedad estándar corregida */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ========== CAROUSEL STYLES ========== */
        #myCarousel {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.25);
        }

        #myCarousel .carousel-item img {
            height: 580px;
            object-fit: cover;
            filter: brightness(0.75);
            transition: transform 4s ease;
        }


        @keyframes kenBurns {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.08);
            }
        }

        /* Gradient overlay for text readability */
        #myCarousel .carousel-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 0.7) 0%,
                    rgba(0, 0, 0, 0.2) 50%,
                    transparent 100%);
            pointer-events: none;
            z-index: 1;
        }

        /* Caption styling */
        #myCarousel .carousel-caption {
            z-index: 2;
            bottom: 50px;
            text-align: left;
            left: 8%;
            right: 40%;
            animation: slideUp 0.7s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #myCarousel .carousel-caption h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.5);
            margin-bottom: 10px;
            line-height: 1.2;
        }

        #myCarousel .carousel-caption p {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.88);
            text-shadow: 0 1px 6px rgba(0, 0, 0, 0.4);
            line-height: 1.5;
            max-width: 500px;
        }

        /* Category badge in carousel */
        .carousel-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 12px;
            color: #fff;
        }

        .carousel-badge-deportes {
            background: #e63946;
        }

        .carousel-badge-tecnologia {
            background: #0077b6;
        }

        .carousel-badge-inter {
            background: #6a0572;
        }

        .carousel-badge-clima {
            background: #00b4d8;
        }

        .carousel-badge-locales {
            background: #2d6a4f;
        }

        .carousel-badge-inicio {
            background: linear-gradient(135deg, #e63946, #0077b6);
        }

        /* Custom indicators — pill style */
        #myCarousel .carousel-indicators {
            bottom: 18px;
            z-index: 3;
            gap: 6px;
        }

        #myCarousel .carousel-indicators button {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.7);
            background: transparent;
            opacity: 0.6;
            transition: all 0.35s ease;
        }

        #myCarousel .carousel-indicators button.active {
            width: 32px;
            border-radius: 10px;
            background: #fff;
            border-color: #fff;
            opacity: 1;
        }

        /* Navigation arrows */
        #myCarousel .carousel-control-prev,
        #myCarousel .carousel-control-next {
            width: 50px;
            height: 50px;
            top: 50%;
            transform: translateY(-50%);
            bottom: auto;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(6px);
            border-radius: 50%;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 3;
        }

        #myCarousel .carousel-control-prev {
            left: 18px;
        }

        #myCarousel .carousel-control-next {
            right: 18px;
        }

        #myCarousel:hover .carousel-control-prev,
        #myCarousel:hover .carousel-control-next {
            opacity: 1;
        }

        #myCarousel .carousel-control-prev:hover,
        #myCarousel .carousel-control-next:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        #myCarousel .carousel-control-prev-icon,
        #myCarousel .carousel-control-next-icon {
            width: 18px;
            height: 18px;
        }

        /* Smooth crossfade transition */
        #myCarousel .carousel-item {
            transition: opacity 0.8s ease-in-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #myCarousel .carousel-item img {
                height: 320px;
            }

            #myCarousel .carousel-caption {
                left: 5%;
                right: 10%;
                bottom: 35px;
            }

            #myCarousel .carousel-caption h1 {
                font-size: 1.4rem;
            }

            #myCarousel .carousel-caption p {
                font-size: 0.85rem;
            }
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