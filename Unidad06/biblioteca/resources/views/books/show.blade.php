@extends('layouts.app')

@section('content')
<h2>{{ $book->title }}</h2>

<p>Autor: {{ $book->author->name }}</p>
<p>Año: {{ $book->published_year }}</p>
<p>ISBN: {{ $book->isbn }}</p>

<p>
    Estado:
    <strong>
        {{ $book->isAvailable() ? 'Disponible' : 'Prestado' }}
    </strong>
</p>

<h3>Categorías</h3>
<ul>
@foreach ($book->categories as $category)
    <li>{{ $category->name }}</li>
@endforeach
</ul>
@endsection
