<h2>Crear sala</h2>
<form action="{{route('salas.update',$sala)}}" method="post">
    @csrf
    @method('PUT')
<label>Nombre</label>
<input type="text" name="nombre" value="{{$sala->nombre}}">
<label>Sala</label>
<input type="number" name="aforo" value="{{$sala->aforo}}">
<button type="submit">Actualizar</button>
</form>
