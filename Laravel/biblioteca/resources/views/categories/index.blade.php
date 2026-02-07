@extends('layouts.app')
@section('content')
<h2>Autores</h2>

<a href="{{route('categories.create')}}">Crear autor</a>
<ul>
@foreach($categories as $category)
<li>{{$category->name}}</li>

<a href="{{route('categories.show', $category)}}">Ver</a>
<a href="{{route('categories.edit', $category)}}">Editar</a>
<form action="{{route('categories.destroy', $category)}}" method="POST">
@csrf
@method('DELETE')
<button type="submit" onclick="return confirm('desea eliminar')">Eliminar</button>
</form>
@endforeach
</ul>
@endsection
