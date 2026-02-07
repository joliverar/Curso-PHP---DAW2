<h2>Actualiar Autor</h2>
<form action="{{route('categories.update', $category)}}" method="post">
    @csrf
    @method('PUT')
<label>Nombre</label>
<input name="name" value="{{$category->name}}">

<button type="submit">Actualizar</button>
</form>