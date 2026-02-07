@extends('layouts.app')

{{---Listado de peliculas---}}
@section('content')

<h2>Salas</h2>
<a href="{{route('salas.create')}}">Nueva Pelicula</a>
<ul>
@foreach($salas as $sala)  
<li>
{{$sala->nombre}}({{$sala->aforo}} personas)
<a href="{{route('salas.show', $sala)}}">Ver</a>
<a href="{{route('salas.edit', $sala)}}">Editar</a>
<form action="{{route('salas.destroy', $sala)}}" method="post" style="display:inline">
    @csrf
    @method('delete')
    <button type="submit" onclick='return confirm("¿Desea eliminar esta proyección?")'>
    Eliminar1
</button>

</form>

</li>
 @endforeach
</ul>
@endsection