<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Categorías
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(auth()->user()->isLibrarian() || auth()->user()->isAdmin())
            <a href="{{ route('categories.create') }}" class="text-blue-600 underline">
                Nueva categoría
            </a>
        @endif

        <ul class="mt-4 space-y-2">
            @forelse($categories as $category)
                <li>
                    <strong>{{ $category->name }}</strong>

                    <a href="{{ route('categories.show', $category) }}" class="text-blue-600">
                        Ver
                    </a>

                    @if(auth()->user()->isLibrarian() || auth()->user()->isAdmin())
                        |
                        <a href="{{ route('categories.edit', $category) }}" class="text-yellow-600">
                            Editar
                        </a>
                    @endif
                </li>
            @empty
                <li>No hay categorías.</li>
            @endforelse
        </ul>

    </div>
</x-app-layout>


