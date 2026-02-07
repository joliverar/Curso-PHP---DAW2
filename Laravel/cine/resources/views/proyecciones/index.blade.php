@extends('layouts.app')

{{---Listado de peliculas---}}
@section('content')

<h2>Proyecciones</h2>

<a href="{{route('proyecciones.create')}}">Nueva proyeccion</a>

<ul>
@foreach ($proyecciones as $proyeccion)
    <li>
        {{$proyeccion->pelicula->titulo}}|{{$proyeccion->sala->nombre}}|{{$proyeccion->fecha_hora}}
        <a href="{{route('proyecciones.show', $proyeccion)}}">Ver</a>
        <a href="{{route('proyecciones.edit', $proyeccion)}}">Editar</a>
        <form action="{{route('proyecciones.destroy', $proyeccion)}}" method="POST" style="display:inline">
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