@extends('layouts.app')

@section('content')
<h1>Categorías</h1>

<p><a href="{{ route('categories.create') }}">Nueva categoría</a></p>

<ul>
  @forelse($categories as $category)
    <li>
      {{ $category->name }}
      @if($category->description) - {{ $category->description }} @endif

      - <a href="{{ route('categories.show', $category) }}">Ver</a>
      - <a href="{{ route('categories.edit', $category) }}">Editar</a>

      <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('¿Eliminar categoría?')">Eliminar</button>
      </form>
    </li>
  @empty
    <li>No hay categorías.</li>
  @endforelse
</ul>

@if(method_exists($categories, 'links'))
  {{ $categories->links() }}
@endif
@endsection
