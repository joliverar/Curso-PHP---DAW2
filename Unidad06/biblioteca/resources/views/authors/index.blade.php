@extends('layouts.app')

@section('content')
<h2>Autores</h2>
<a href="/authors/create">
    <button>Crear autor</button>
</a>

@foreach ($authors as $author)
    <li>
        
            {{ $author->name }} ({{ $author->country }})
      
         <a href="/authors/{{ $author->id }}">
            <button>Ver</button>
        </a>

        <a href="/authors/{{ $author->id }}/edit">
            <button>Editar</button>
        </a>
        <form action="/authors/{{ $author->id }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                onclick="return confirm('¿Seguro que deseas eliminar este autor?')">
                Eliminar
            </button>
        </form>
    </li>
@endforeach
</ul>
@endsection


@if(session()->has('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(session()->has('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif
