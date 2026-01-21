@extends('layouts.app')

@section('content')
<h2>{{ $author->name }}</h2>

<p>País: {{ $author->country }}</p>
<p>Fecha nacimiento: {{ $author->birth_date }}</p>

<h3>Libros</h3>
<ul>
@foreach ($author->books as $book)
    <li>{{ $book->title }}</li>
@endforeach
</ul>
@endsection
