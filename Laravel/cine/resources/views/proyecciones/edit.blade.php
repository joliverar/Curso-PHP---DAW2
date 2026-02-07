<h2>Editar proyeccion</h2>

<form action="{{route('proyecciones.update', $proyeccion)}}" method="post">
@csrf
@method('PUT')
<label>Pelicula</label>
<select name="pelicula_id">
    @foreach($peliculas as $pelicula)
    <option value="{{$pelicula->id}}" @if ($pelicula->id == $proyeccion->pelicula_id) selected @endif>
        {{$pelicula->titulo}}
    </option>
    @endforeach
</select>
<label>Sala</label>
<select name="sala_id">
     @foreach($salas as $sala)
    <option value="{{$sala->id}}" @if ($sala->id == $proyeccion->sala_id) selected @endif>
        {{$sala->nombre}}
    </option>
    @endforeach
</select>
<label>Fecha y Hora</label>
<input name="fecha_hora" type="datetime-local" value="{{$proyeccion->fecha_hora}}">
<button type="submit">Crear</button>
</form>