@extends('layouts.app')

@section('title', 'Aprendices')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Aprendices</h1>
    <a href="{{ route('apprentices.create') }}" class="btn btn-success">Nuevo Aprendiz</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th><th>Foto</th><th>Nombre</th><th>Email</th>
                    <th>Celular</th><th>Curso</th><th>Computador</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($apprentices as $apprentice)
                    <tr>
                        <td>{{ data_get($apprentice, 'id') }}</td>
                        <td>
                            @if(data_get($apprentice, 'photo_url'))
                                <img src="{{ data_get($apprentice, 'photo_url') }}" alt="Foto de {{ data_get($apprentice, 'name') }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            @else
                                Sin foto
                            @endif
                        </td>
                        <td>{{ data_get($apprentice, 'name') }}</td>
                        <td>{{ data_get($apprentice, 'email') }}</td>
                        <td>{{ data_get($apprentice, 'cell_number') }}</td>
                        <td>{{ data_get($apprentice, 'course.course_number', 'N/A') }}</td>
                        <td>{{ data_get($apprentice, 'computer.number', 'Sin asignar') }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('apprentices.show', data_get($apprentice, 'id')) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('apprentices.edit', data_get($apprentice, 'id')) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('apprentices.destroy', data_get($apprentice, 'id')) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar este aprendiz?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">No hay aprendices registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
