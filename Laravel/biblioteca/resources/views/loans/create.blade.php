<h2>Crear Autor</h2>
<form action="{{route('loans.store')}}" method="post">
    @csrf
<label>Nombre</label>
<select name="book_id">
    @foreach($books as $book)
    <option value="{{$book->id}}">
        {{$book->title}}
    </option>
    @endforeach
</select>
<label>usuario</label>
<input name="user_name">
<label>Fecha de prestamo</label>
<input type="date">
<label>Fecha de devolucion</label>
<input type="date">
<button type="submit">Guardar</button>
</form>