@extends('layouts.app')

{{---Listado de peliculas---}}
@section('content')
<h1>Películas</h1>

<a href="{{route('peliculas.create')}}">Nueva Pelicula</a>
<ul>
    @foreach($peliculas as $p)
    <li>
        {{$p->titulo}}({{$p->duracion}} min)
        <a href="{{route('peliculas.show', $p)}}">ver</a>
        <a href="{{route('peliculas.edit',$p)}}">Editar</a>
        <form action="{{route('peliculas.destroy',$p)}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
        </form>
    </li>
    @endforeach
</ul>
@endsection