@extends('layouts.app')
@section('content')
<h2>Autores</h2>

<a href="{{route('authors.create')}}">Crear autor</a>
<ul>
@foreach($authors as $author)
<li>{{$author->name}} - {{$author->country}}</li>

<a href="{{route('authors.show', $author)}}">Ver</a>
<a href="{{route('authors.edit', $author)}}">Editar</a>
<form action="{{route('authors.destroy', $author)}}" method="POST">
@csrf
@method('DELETE')
<button type="submit" onclick="return confirm('desea eliminar')">Eliminar</button>
</form>
@endforeach
</ul>
@endsection
