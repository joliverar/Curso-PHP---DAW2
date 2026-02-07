<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Libros</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-3 text-green-600">{{ session('success') }}</div>
        @endif

        <a href="{{ route('books.create') }}" class="text-blue-600 underline">Nuevo libro</a>

        <table class="mt-4 w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Título</th>
                    <th class="p-2 border">Autor</th>
                    <th class="p-2 border">Disponible</th>
                    <th class="p-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td class="p-2 border">{{ $book->title }}</td>
                    <td class="p-2 border">{{ $book->author->name }}</td>
                    <td class="p-2 border">
                        <span class="{{ $book->is_available ? 'text-green-600' : 'text-red-600' }}">
                            {{ $book->is_available ? 'Sí' : 'No' }}
                        </span>
                    </td>
                    <td class="p-2 border">
                        <a href="{{ route('books.edit', $book) }}" class="text-blue-600">Editar</a>
                        <form method="POST" action="{{ route('books.destroy', $book) }}" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-600 ml-2">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
