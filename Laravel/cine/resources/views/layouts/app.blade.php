<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cine Laravel</title>

    <!-- Estilos simples -->
    <style>
        body { font-family: Arial; margin: 0; }
        nav { background: #222; padding: 15px; }
        nav a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover { text-decoration: underline; }
        .container { padding: 20px; }
    </style>
</head>
<body>

    <!-- MENÚ PRINCIPAL -->
    <nav>
        <a href="{{ route('home') }}">Inicio</a>
        <a href="{{ route('peliculas.index') }}">Películas</a>
        <a href="{{ route('salas.index') }}">Salas</a>
        <a href="{{ route('proyecciones.index') }}">Proyecciones</a>
    </nav>

    <!-- CONTENIDO -->
    <div class="container">
        @yield('content')
    </div>

</body>
</html>
