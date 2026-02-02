@extends('layouts.app')

@section('content')
<h1>Editar libro</h1>

<form method="POST" action="{{ route('books.update', $book) }}">
  @csrf
  @method('PUT')

  <div>
    <label>Título</label><br>
    <input name="title" value="{{ old('title', $book->title) }}">
    @error('title') <div>{{ $message }}</div> @enderror
  </div>

  <div>
    <label>ISBN</label><br>
    <input name="isbn" value="{{ old('isbn', $book->isbn) }}">
    @error('isbn') <div>{{ $message }}</div> @enderror
  </div>

  <div>
    <label>Año publicación</label><br>
    <input name="published_year" type="number" value="{{ old('published_year', $book->published_year) }}">
    @error('published_year') <div>{{ $message }}</div> @enderror
  </div>

  <div>
    <label>Autor</label><br>
    <select name="author_id">
      <option value="">-- sin autor --</option>
      @foreach($authors as $author)
        <option value="{{ $author->id }}"
          {{ (string)old('author_id', $book->author_id) === (string)$author->id ? 'selected' : '' }}>
          {{ $author->name }}
        </option>
      @endforeach
    </select>
    @error('author_id') <div>{{ $message }}</div> @enderror
  </div>

  <div>
    <label>Categorías</label><br>
    @php
      $selected = old('categories', $book->categories->pluck('id')->toArray());
    @endphp

    @foreach($categories as $category)
      <label>
        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
          {{ in_array($category->id, $selected) ? 'checked' : '' }}>
        {{ $category->name }}
      </label><br>
    @endforeach
    @error('categories') <div>{{ $message }}</div> @enderror
  </div>

  <button type="submit">Actualizar</button>
  <a href="{{ route('books.index') }}">Cancelar</a>
</form>
@endsection
