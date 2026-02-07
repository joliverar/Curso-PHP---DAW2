@extends('layouts.app')
@section('content')
<h2>Prestamos</h2>

<a href="{{route('loans.create')}}">Registrar Prestamo</a>
<ul>
@foreach($loans as $loan)
<li>{{$loan->book->title}} - {{$loan->user_name}} - {{$loan->return_date}} -{{$loan->loan_date}}</li>


  {{-- BOTÓN DEVOLVER (solo si no está devuelto) --}}
        @if($loan->return_date === null)
            <form action="{{ route('loans.return', $loan) }}" method="POST" style="display:inline">
                @csrf
                @method('PUT')
                <button type="submit">
                    Devolver
                </button>
            </form>
        @endif
<form action="{{route('loans.destroy', $loan)}}" method="POST">
@csrf
@method('DELETE')
<button type="submit" onclick="return confirm('desea eliminar')">Eliminar</button>
</form>
@endforeach
</ul>
@endsection
