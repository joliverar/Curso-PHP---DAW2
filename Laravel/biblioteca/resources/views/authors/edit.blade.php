<h2>Actualiar Autor</h2>
<form action="{{route('authors.update', $author)}}" method="post">
    @csrf
    @method('PUT')
<label>Nombre</label>
<input name="name" value="{{$author->name}}">
<label>Pais</label>
<input name="country" value="{{$author->country}}">
<button type="submit">Actualizar</button>
</form>