<h2>Crear Categoria</h2>
<form action="{{route('categories.store')}}" method="post">
    @csrf
<label>Nombre</label>
<input name="name">

<button type="submit">Guardar</button>
</form>