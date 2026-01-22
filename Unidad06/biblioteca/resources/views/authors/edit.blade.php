@extends('layouts.app')

@section('content')
<h2>Editar Autor</h2>

<form method="POST" action="/authors/{{ $author->id }}">
    @csrf
    @method('PUT')

    <div>
        <label>Nombre</label><br>
        <input
            type="text"
            name="name"
            value="{{ $author->name }}"
            required
        >
    </div>

    <div>
        <label>País</label><br>
        <input
            type="text"
            name="country"
            value="{{ $author->country }}"
        >
    </div>

    <div>
        <label>Fecha de nacimiento</label><br>
        <input
            type="date"
            name="birth_date"
            value="{{ $author->birth_date?->format('Y-m-d') }}"
        >
    </div>

    <br>

    <button type="submit">Actualizar</button>
</form>
@endsection
