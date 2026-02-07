<h2>Crear sala</h2>
<form action="{{route('salas.store')}}" method="post">
    @csrf
<label>Nombre</label>
<input type="text" name="nombre">
<label>Sala</label>
<input type="number" name="aforo">
<button type="submit">Guardar</button>
</form>
