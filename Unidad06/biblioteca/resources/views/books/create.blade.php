@extends('layouts.app')

@section('content')
<h2>Crear Libro</h2>

<form method="POST" action="/books">
    @csrf

    <label>Título</label><br>
    <input type="text" name="title" required><br><br>

    <label>ISBN</label><br>
    <input type="text" name="isbn" required><br><br>

    <label>Año</label><br>
    <input type="number" name="published_year"><br><br>

    <label>Autor</label><br>
    <select name="author_id" required>
        @foreach ($authors as $author)
            <option value="{{ $author->id }}">
                {{ $author->name }}
            </option>
        @endforeach
    </select><br><br>

    <label>Categorías</label><br>
    @foreach ($categories as $category)
        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
        {{ $category->name }}<br>
    @endforeach

    <br>
    <button type="submit">Guardar</button>
</form>
@endsection
