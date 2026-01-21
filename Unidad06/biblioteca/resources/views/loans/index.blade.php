@extends('layouts.app')

@section('content')
<h2>Préstamos</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>Usuario</th>
        <th>Libro</th>
        <th>Estado</th>
        <th>Fecha préstamo</th>
        <th>Acciones</th>
    </tr>

@foreach ($loans as $loan)
    <tr>
        <td>{{ $loan->user->name }}</td>
        <td>{{ $loan->book->title }}</td>
        <td>{{ $loan->status }}</td>
        <td>{{ $loan->loaned_at }}</td>
        <td>
            @if($loan->isOpen())
                <form method="POST" action="/loans/{{ $loan->id }}/return">
                    @csrf
                    @method('PUT')
                    <button type="submit">Devolver</button>
                </form>
            @endif
        </td>
    </tr>
@endforeach
</table>
@endsection
