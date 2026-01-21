@extends('layouts.app')

@section('content')
<h2>Libros</h2>

<ul>
@foreach ($books as $book)
    <li>
        <a href="/books/{{ $book->id }}">
            {{ $book->title }}
        </a>
        - {{ $book->author->name }}
    </li>
@endforeach
</ul>
@endsection
