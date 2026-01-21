@extends('layouts.app')

@section('content')
<h2>Categorías</h2>

<ul>
@foreach ($categories as $category)
    <li>
        <a href="/categories/{{ $category->id }}">
            {{ $category->name }}
        </a>
    </li>
@endforeach
</ul>
@endsection
