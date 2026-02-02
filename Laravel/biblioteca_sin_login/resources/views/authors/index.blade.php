@extends('layouts.app')

@section('title', 'Autores')

@section('content')
<h1>Autores</h1>

<p><a href="{{ route('authors.create') }}">Nuevo autor</a></p>

<ul>
  @forelse($authors as $author)
    <li>
      {{ $author->name }}
      @if($author->country) - {{ $author->country }} @endif
      @if($author->birth_date) - {{ optional($author->birth_date)->format('Y-m-d') }} @endif

      - <a href="{{ route('authors.show', $author) }}">Ver</a>
      - <a href="{{ route('authors.edit', $author) }}">Editar</a>

      <form action="{{ route('authors.destroy', $author) }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('¿Eliminar autor?')">Eliminar</button>
      </form>
    </li>
  @empty
    <li>No hay autores.</li>
  @endforelse
</ul>

@if(method_exists($authors, 'links'))
  {{ $authors->links() }}
@endif
@endsection
