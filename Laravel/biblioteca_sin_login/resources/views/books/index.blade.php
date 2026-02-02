@extends('layouts.app')

@section('content')
<h1>Libros</h1>

<p><a href="{{ route('books.create') }}">Nuevo libro</a></p>

<ul>
  @forelse($books as $book)
    <li>
      {{ $book->title }}
      @if($book->isbn) (ISBN: {{ $book->isbn }}) @endif
      @if($book->published_year) - {{ $book->published_year }} @endif
      @if(optional($book->author)->name) - Autor: {{ $book->author->name }} @endif

      - <a href="{{ route('books.show', $book) }}">Ver</a>
      - <a href="{{ route('books.edit', $book) }}">Editar</a>

      <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('¿Eliminar libro?')">Eliminar</button>
      </form>
    </li>
  @empty
    <li>No hay libros.</li>
  @endforelse
</ul>

@if(method_exists($books, 'links'))
  {{ $books->links() }}
@endif
@endsection
