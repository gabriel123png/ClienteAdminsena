@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Centros de Formación</h2>

        <a href="{{ route('training_centers.create') }}" class="btn btn-primary">
            Nuevo Centro
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse($trainingCenters ?? [] as $trainingCenter)
            @php
                $id = is_array($trainingCenter) ? ($trainingCenter['id'] ?? '') : ($trainingCenter->id ?? '');
                $name = is_array($trainingCenter) ? ($trainingCenter['name'] ?? '') : ($trainingCenter->name ?? '');
                $location = is_array($trainingCenter) ? ($trainingCenter['location'] ?? '') : ($trainingCenter->location ?? '');
            @endphp

            <tr>
                <td>{{ $id }}</td>
                <td>{{ $name }}</td>
                <td>{{ $location }}</td>

                <td>

                    <a href="{{ route('training_centers.edit', $id) }}"
                       class="btn btn-warning btn-sm">
                        Editar
                    </a>

                    <form action="{{ route('training_centers.destroy', $id) }}"
                          method="POST"
                          style="display:inline">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Deseas eliminar este centro?')">
                            Eliminar
                        </button>

                    </form>

                </td>
            </tr>

            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay centros registrados.</td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>

@endsection