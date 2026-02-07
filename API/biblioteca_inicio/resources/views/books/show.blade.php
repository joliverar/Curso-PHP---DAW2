@extends('layouts.app')

@section('content')
  <h1>{{ $book->title }}</h1>

  <p><strong>ISBN:</strong> {{ $book->isbn ?? '-' }}</p>
  <p><strong>Año:</strong> {{ $book->published_year ?? '-' }}</p>
  <p><strong>Autor:</strong> {{ optional($book->author)->name ?? '-' }}</p>

  <p><strong>Categorías:</strong>
    @if($book->categories->isEmpty())
      -
    @else
      {{ $book->categories->pluck('name')->join(', ') }}
    @endif
  </p>

  <p>
    <a href="{{ route('books.edit', $book) }}">Editar</a>
    <a href="{{ route('books.index') }}">Volver</a>
  </p>
@endsection
