@extends('layouts.app')

@section('content')
<h1>Nuevo autor</h1>

<form method="POST" action="{{ route('authors.store') }}">
  @csrf

  <div>
    <label>Nombre</label><br>
    <input name="name" value="{{ old('name') }}">
    @error('name') <div>{{ $message }}</div> @enderror
  </div>

  <div>
    <label>País</label><br>
    <input name="country" value="{{ old('country') }}">
    @error('country') <div>{{ $message }}</div> @enderror
  </div>

  <div>
    <label>Fecha de nacimiento</label><br>
    <input type="date" name="birth_date" value="{{ old('birth_date') }}">
    @error('birth_date') <div>{{ $message }}</div> @enderror
  </div>

  <button type="submit">Guardar</button>
  <a href="{{ route('authors.index') }}">Cancelar</a>
</form>
@endsection
