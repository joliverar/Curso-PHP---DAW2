@extends('layouts.app')

@section('content')
<h1>Editar categoría</h1>

<form method="POST" action="{{ route('categories.update', $category) }}">
  @csrf
  @method('PUT')

  <div>
    <label>Nombre</label><br>
    <input name="name" value="{{ old('name', $category->name) }}">
    @error('name') <div>{{ $message }}</div> @enderror
  </div>

  <div>
    <label>Descripción</label><br>
    <input name="description" value="{{ old('description', $category->description) }}">
    @error('description') <div>{{ $message }}</div> @enderror
  </div>

  <button type="submit">Actualizar</button>
  <a href="{{ route('categories.index') }}">Cancelar</a>
</form>
@endsection
