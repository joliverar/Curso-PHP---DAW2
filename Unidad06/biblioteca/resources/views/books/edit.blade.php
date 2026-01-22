@extends('layouts.app')

@section('content')
<h2>Editar Libro</h2>

<form method="POST" action="/books/{{ $book->id }}">
    @csrf
    @method('PUT')

    <label>Título</label><br>
    <input type="text" name="title" value="{{ $book->title }}" required><br><br>

    <label>ISBN</label><br>
    <input type="text" name="isbn" value="{{ $book->isbn }}" required><br><br>

    <label>Año</label><br>
    <input type="number" name="published_year" value="{{ $book->published_year }}"><br><br>

    <label>Autor</label><br>
    <select name="author_id">
        @foreach ($authors as $author)
            <option value="{{ $author->id }}"
                @selected($book->author_id == $author->id)>
                {{ $author->name }}
            </option>
        @endforeach
    </select><br><br>

    <label>Categorías</label><br>
    @foreach ($categories as $category)
        <input type="checkbox"
               name="categories[]"
               value="{{ $category->id }}"
               @checked($book->categories->contains($category->id))>
        {{ $category->name }}<br>
    @endforeach

    <br>
    <button type="submit">Actualizar</button>
</form>
@endsection
