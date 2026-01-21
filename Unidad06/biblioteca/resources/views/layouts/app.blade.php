<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
</head>
<body>

    <header>
        <h1>Biblioteca</h1>
        <nav>
            <a href="/authors">Autores</a> |
            <a href="/books">Libros</a> |
            <a href="/categories">Categorías</a> |
            <a href="/loans">Préstamos</a>
        </nav>
        <hr>
    </header>

    <main>
        @yield('content')
    </main>

</body>
</html>
