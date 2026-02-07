@extends('layouts.app')
@section('content')
<h2>{{$book->title}}</h2>

<p>Año: {{$book->year}}</p>
<p>Autor: {{$book->author->name}}</p>
<p>Categoria: {{$book->category->name}}</p>
<p>Disponible: {{$book->available?"si":"no"}}</p>
@endsection