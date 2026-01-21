@extends('layouts.app')

@section('content')
<h2>{{ $category->name }}</h2>

<h3>Libros</h3>
<ul>
@foreach ($category->books as $book)
    <li>{{ $book->title }}</li>
@endforeach
</ul>
@endsection
