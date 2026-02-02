@extends('layouts.app')

@section('content')
<h1>Editar autor</h1>

<form method="POST" action="{{ route('authors.update', $author) }}">
  @csrf
  @method('PUT')

  <div>
    <label>Nombre</label><br>
    <input name="name" value="{{ old('name', $author->name) }}">
    @error('name') <div>{{ $message }}</div> @enderror
  </div>

  <div>
    <label>País</label><br>
    <input name="country" value="{{ old('country', $author->country) }}">
    @error('country') <div>{{ $message }}</div> @enderror
  </div>

  <div>
    <label>Fecha de nacimiento</label><br>
    <input type="date" name="birth_date" value="{{ old('birth_date', optional($author->birth_date)->format('Y-m-d')) }}">
    @error('birth_date') <div>{{ $message }}</div> @enderror
  </div>

  <button type="submit">Actualizar</button>
  <a href="{{ route('authors.index') }}">Cancelar</a>
</form>
@endsection
