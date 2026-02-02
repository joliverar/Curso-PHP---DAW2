@extends('layouts.app')

@section('content')
  <h1>{{ $author->name }}</h1>

  <p><strong>País:</strong> {{ $author->country ?? '-' }}</p>
  <p><strong>Nacimiento:</strong> {{ optional($author->birth_date)->format('Y-m-d') ?? '-' }}</p>

  <p>
    <a href="{{ route('authors.edit', $author) }}">Editar</a>
    <a href="{{ route('authors.index') }}">Volver</a>
  </p>
@endsection
