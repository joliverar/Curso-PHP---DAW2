@extends('layouts.app')

@section('content')
<h2>Libros</h2>

<a href="/books/create">
    <button>Crear libro</button>
</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<ul>
@foreach ($books as $book)
    <li>
        <strong>{{ $book->title }}</strong>
        ({{ $book->author->name }})

        <a href="/books/{{ $book->id }}">
            <button>Ver</button>
        </a>

        <a href="/books/{{ $book->id }}/edit">
            <button>Editar</button>
        </a>

        <form action="/books/{{ $book->id }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                onclick="return confirm('¿Eliminar este libro?')">
                Eliminar
            </button>
        </form>
    </li>
@endforeach
</ul>
@endsection

