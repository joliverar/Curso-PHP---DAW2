@extends('layouts.app')
@section('content')


<h2>Libros</h2>

<a href="{{route('books.create')}}">Crear Libro</a>
<ul>
@foreach($books as $book)
<li>{{$book->title}} - {{$book->year}} - {{$book->author->name}}- {{$book->category->name}}- {{$book->available?"si":"no"}}</li>

<a href="{{route('books.show', $book)}}">Ver</a>
<a href="{{route('books.edit', $book)}}">Editar</a>
<form action="{{route('books.destroy', $book)}}" method="POST">
@csrf
@method('DELETE')
<button type="submit" onclick="return confirm('desea eliminar')">Eliminar</button>
</form>
@endforeach
</ul>
@endsection
