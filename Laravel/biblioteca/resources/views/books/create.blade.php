@if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@if(session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif

@if(session('error'))
    <p style="color: red;">
        {{ session('error') }}
    </p>
@endif
<h2>Crear libro</h2>
<form action="{{route('books.store')}}" method="post">
    @csrf
<label>Titulo</label>
<input name="title">
<label>Año</label>
<input name="year">
<label>Autor</label>
<select name="author_id">
    @foreach($authors as $author)
    <option value="{{$author->id}}">
        {{$author->name}}
    </option>
    @endforeach
</select>
<label>Categoria</label>
<select name="category_id">
     @foreach($categories as $category)
    <option value="{{$category->id}}">
        {{$category->name}}
    </option>
    @endforeach
</select>
<label>Disponible</label>
<input type="checkbox" name="available" value=1 checked>
<button type="submit">Guardar</button>
</form>