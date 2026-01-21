@extends('layouts.app')

@section('content')
<h2>Autores</h2>

<ul>
@foreach ($authors as $author)
    <li>
        <a href="/authors/{{ $author->id }}">
            {{ $author->name }} ({{ $author->country }})
        </a>
    </li>
@endforeach
</ul>
@endsection
