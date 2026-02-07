@if(session('success'))
    <div class="mb-4 text-green-600">
        {{ session('success') }}
    </div>
@endif


@php
$colors = [
 'pending' => 'text-yellow-600',
 'approved' => 'text-blue-600',
 'returned' => 'text-green-600',
 'rejected' => 'text-red-600'
];
@endphp



<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis préstamos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">Libro</th>
                            <th class="p-2 border">Estado</th>
                            <th class="p-2 border">Vence</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loans as $loan)
                            <tr>
                                <td class="p-2 border">
                                    {{ $loan->book->title ?? '—' }}
                                </td>
                                <td class="p-2 border">
                                    <span class="{{ $colors[$loan->status] ?? 'text-gray-600' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="p-2 border">
                                    {{ $loan->due_date ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-500">
                                    No tienes préstamos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
