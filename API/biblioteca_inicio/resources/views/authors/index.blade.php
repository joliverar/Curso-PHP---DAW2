<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Autores
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(auth()->user()->isLibrarian() || auth()->user()->isAdmin())
            <a href="{{ route('authors.create') }}" class="text-blue-600 underline">
                Nuevo autor
            </a>
        @endif

        <ul class="mt-4 space-y-2">
            @forelse($authors as $author)
                <li>
                    <strong>{{ $author->name }}</strong>

                    <a href="{{ route('authors.show', $author) }}" class="text-blue-600">
                        Ver
                    </a>

                    @if(auth()->user()->isLibrarian() || auth()->user()->isAdmin())
                        |
                        <a href="{{ route('authors.edit', $author) }}" class="text-yellow-600">
                            Editar
                        </a>
                    @endif
                </li>
            @empty
                <li>No hay autores.</li>
            @endforelse
        </ul>

    </div>
</x-app-layout>

