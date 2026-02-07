<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Autores
        </h2>
    </x-slot>

    <div class="py-6">
        @if(auth()->user()->isLibrarian() || auth()->user()->isAdmin())
            <a href="{{ route('authors.create') }}">Nuevo autor</a>
        @endif

        <ul>
            @foreach($authors as $author)
                <li>
                    {{ $author->name }}
                    <a href="{{ route('authors.show', $author) }}">Ver</a>

                    @if(auth()->user()->isLibrarian() || auth()->user()->isAdmin())
                        <a href="{{ route('authors.edit', $author) }}">Editar</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>

