<h2>Crear Autor</h2>
<form action="{{route('authors.store')}}" method="post">
    @csrf
<label>Nombre</label>
<input name="name">
<label>Pais</label>
<input name="country">
<button type="submit">Guardar</button>
</form>