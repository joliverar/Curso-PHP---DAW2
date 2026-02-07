<h1>Nueva Pelicula</h2>

<form action="{{route('peliculas.store')}}" method="post">
    @csrf
    <label>Titulo</label>
    <input name="titulo" type="text">
    <label>Duracion</label>
    <input name="duracion" type="number">
    <button type="submit">Guardar</button>
</form>