<h2>Detalle proyeccion</h2>


<p>Pelicula: {{$proyeccion->pelicula->titulo}}</p>
<p>nombre:{{$proyeccion->sala->nombre}}</p>
<p>Fecha y hora:{{$proyeccion->fecha_hora}}</p>

<a href="{{route('proyecciones.index')}}">Volver</a>