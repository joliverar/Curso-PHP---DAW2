<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Solicitar préstamo
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('loans.store') }}">
                    @csrf

                    <div>
                        <x-label for="book_id" value="Libro" />
                        <select name="book_id" id="book_id" class="mt-1 block w-full border rounded">
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">
                                    {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-button>
                            Solicitar
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
