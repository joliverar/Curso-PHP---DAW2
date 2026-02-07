<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">{{ isset($book) ? 'Editar' : 'Crear' }} libro</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto">
        <x-validation-errors class="mb-4" />

        <form method="POST"
              action="{{ isset($book) ? route('books.update',$book) : route('books.store') }}">
            @csrf
            @isset($book) @method('PUT') @endisset

            <x-label value="Título" />
            <x-input name="title" class="w-full" value="{{ $book->title ?? '' }}" />

            <x-label value="Autor" class="mt-3" />
            <select name="author_id" class="w-full border rounded">
                @foreach($authors as $author)
                    <option value="{{ $author->id }}"
                        @selected(isset($book) && $book->author_id==$author->id)>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
           
    <x-label for="isbn" value="ISBN" />
    <x-input id="isbn" name="isbn" type="text" class="mt-1 block w-full" required />

    <x-label for="published_year" value="Año de publicación" />
    <x-input
        id="published_year"
        name="published_year"
        type="number"
        min="1000"
        max="{{ date('Y') }}"
        class="mt-1 block w-full"
        required
    />

            <label class="block mt-3">
                <input type="checkbox" name="is_available"
                    @checked(!isset($book) || $book->is_available)> Disponible
            </label>

            <x-button class="mt-4">Guardar</x-button>
        </form>
    </div>
</x-app-layout>

