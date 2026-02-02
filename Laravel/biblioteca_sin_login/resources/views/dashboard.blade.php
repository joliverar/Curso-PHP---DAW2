@extends('layouts.classic')

@section('content')
  @include('partials.flash')

  <div class="bg-white shadow rounded-md p-6 space-y-4">
    <h1 class="text-2xl font-bold">Biblioteca</h1>

    <p class="text-sm text-gray-600">
      Bienvenido/a, <span class="font-medium">{{ auth()->user()->name }}</span>.
      Tu rol es: <span class="font-semibold">{{ auth()->user()->role }}</span>.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <a href="{{ route('books.index') }}" class="block rounded-lg border p-4 hover:bg-gray-50">
        <div class="font-semibold">Libros</div>
        <div class="text-sm text-gray-600">Ver catálogo y filtrar por disponibilidad.</div>
      </a>

      <a href="{{ route('authors.index') }}" class="block rounded-lg border p-4 hover:bg-gray-50">
        <div class="font-semibold">Autores</div>
        <div class="text-sm text-gray-600">Listado de autores.</div>
      </a>

      <a href="{{ route('categories.index') }}" class="block rounded-lg border p-4 hover:bg-gray-50">
        <div class="font-semibold">Categorías</div>
        <div class="text-sm text-gray-600">Listado de categorías.</div>
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <a href="{{ route('myloans.index') }}" class="block rounded-lg border p-4 hover:bg-gray-50">
        <div class="font-semibold">Mis préstamos</div>
        <div class="text-sm text-gray-600">Consulta tus préstamos.</div>
      </a>

      @if(auth()->user()?->role === 'bibliotecario')
        <a href="{{ route('loans.index') }}" class="block rounded-lg border p-4 hover:bg-gray-50">
          <div class="font-semibold">Gestión de préstamos</div>
          <div class="text-sm text-gray-600">Crear y devolver préstamos.</div>
        </a>
      @endif
    </div>
  </div>
@endsection
