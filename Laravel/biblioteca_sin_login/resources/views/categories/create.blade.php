@extends('layouts.app')

@section('content')
<h1>Nueva categoría</h1>

<form method="POST" action="{{ route('categories.store') }}">
  @csrf

  <div>
    <label>Nombre</label><br>
    <input name="name" value="{{ old('name') }}">
    @error('name') <div>{{ $message }}</div> @enderror
  </div>

  <div>
    <label>Descripción</label><br>
    <input name="description" value="{{ old('description') }}">
    @error('description') <div>{{ $message }}</div> @enderror
  </div>

  <button type="submit">Guardar</button>
  <a href="{{ route('categories.index') }}">Cancelar</a>
</form>
@endsection
