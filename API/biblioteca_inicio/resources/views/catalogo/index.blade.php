@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Catálogo de libros
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">Título</th>
                            <th class="p-2 border">Autor</th>
                            <th class="p-2 border">Año</th>
                            <th class="p-2 border">Disponibilidad</th>
                            <th class="p-2 border">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td class="p-2 border">{{ $book->title }}</td>
                                <td class="p-2 border">{{ $book->author->name ?? '—' }}</td>
                                <td class="p-2 border">{{ $book->published_year ?? '—' }}</td>
                                
                                <td class="p-2 border">
                                    @if($book->is_available)
                                        <span class="text-green-600 font-semibold">Disponible</span>
                                    @else
                                        <span class="text-red-600 font-semibold">No disponible</span>
                                    @endif
                                </td>
                                <td class="p-2 border text-center">
    @auth
        @if(auth()->user()->role === 'user')
            @if($book->is_available)
                <form method="POST" action="{{ route('loans.store') }}">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <button class="text-blue-600 underline">
                        Solicitar
                    </button>
                </form>
            @else
                <span class="text-gray-400">No disponible</span>
            @endif
        @else
            —
        @endif
    @endauth
</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">
                                    No hay libros registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>

