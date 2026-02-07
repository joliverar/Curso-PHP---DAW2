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
            Gestión de préstamos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">Socio</th>
                            <th class="p-2 border">Libro</th>
                            <th class="p-2 border">Estado</th>
                            <th class="p-2 border">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr>
                                <td class="p-2 border">{{ $loan->user->name }}</td>
                                <td class="p-2 border">{{ $loan->book->title }}</td>
                                <td class="p-2 border">
                                    <span class="{{ $colors[$loan->status] ?? 'text-gray-600' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="p-2 border">
                                    @if($loan->status === 'pending')
                                        <form method="POST" action="{{ route('loans.approve', $loan->id) }}" class="inline">
                                            @csrf
                                            <button class="text-green-600">Aprobar</button>
                                        </form>

                                        <form method="POST" action="{{ route('loans.reject', $loan->id) }}" class="inline ml-2">
                                            @csrf
                                            <button class="text-red-600">Rechazar</button>
                                        </form>
                                    @elseif($loan->status === 'approved')
                                        <form method="POST" action="{{ route('loans.return', $loan->id) }}" class="inline">
                                            @csrf
                                            <button class="text-blue-600">Marcar devuelto</button>
                                        </form>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>

