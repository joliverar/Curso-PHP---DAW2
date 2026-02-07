<h1>Editar Pelicula</h2>

<form action="{{route('peliculas.update', $pelicula)}}" method="post">
    @csrf
    @method('PUT');
    <label>Titulo</label>
    <input name="titulo" type="text" value="{{$pelicula->titulo}}">
    <label>Duracion</label>
    <input name="duracion" type="number"  value="{{$pelicula->duracion}}">
    <button type="submit">Actualizar</button>
</form>