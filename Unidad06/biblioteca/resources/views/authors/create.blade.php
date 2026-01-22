@extends('layouts.app')

@section('content')
<h2>Crear Autor</h2>

<form method="POST" action="/authors">
    @csrf

    <div>
        <label>Nombre</label><br>
        <input type="text" name="name" required>
    </div>

    <div>
        <label>País</label><br>
        <input type="text" name="country">
    </div>

    <div>
        <label>Fecha de nacimiento</label><br>
        <input type="date" name="birth_date">
    </div>

    <br>

    <button type="submit">Guardar</button>
</form>
@endsection
