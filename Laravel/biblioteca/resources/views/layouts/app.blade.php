<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
</head>
<body>
    <nav>
        <ul>
            <a href="{{ route('home')}}">Inicio</a>
            <a href="{{route('authors.index')}}">Autores</a>
             <a href="{{route('books.index')}}">Libros</a>
              <a href="{{route('categories.index')}}">Categorias</a>
               <a href="{{route('loans.index')}}">Prestamos</a>
        </uL>

    </nav>
    <div class="container">
         @yield('content')
</div>
   
    
</body>
</html>