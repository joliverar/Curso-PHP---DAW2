<h2>Crear proyeccion</h2>

<form action="{{route('proyecciones.store')}}" method="post">
    @csrf
<label>Pelicula</label>
<select name="pelicula_id">
    @foreach($peliculas as $pelicula)
    <option value="{{$pelicula->id}}">
        {{$pelicula->titulo}}
    </option>
    @endforeach
</select>
<label>Sala</label>
<select name="sala_id">
     @foreach($salas as $sala)
    <option value="{{$sala->id}}">
        {{$sala->nombre}}
    </option>
    @endforeach
</select>
<label>Fecha y Hora</label>
<input name="fecha_hora" type="datetime-local">
<button type="submit">Crear</button>
</form>