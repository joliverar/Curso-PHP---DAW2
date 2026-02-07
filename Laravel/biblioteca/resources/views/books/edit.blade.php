<h2>Editar libro</h2>
<form action="{{route('books.update', $book)}}" method="post">
    @csrf
    @method('PUT')
<label>Titulo</label>
<input name="title" value="{{$book->title}}">
<label>Año</label>
<input name="year" value="{{$book->year}}">
<label>Autor</label>
<select name="author_id">
    @foreach($authors as $author)
    <option value="{{$author->id}}" @if ($book->author_id === $author->id) selected @endif">
        {{$author->name}}
    </option>
    @endforeach
</select>
<label>Categoria</label>
<select name="category_id">
     @foreach($categories as $category)
    <option value="{{$category->id}}" @if ($category->id === $book->category_id) selected @endif>
        {{$category->name}}
    </option>
    @endforeach
</select>
<label>Disponible</label>
<input type="checkbox" name="available" value=1 checked>
<button type="submit">Guardar</button>
</form>