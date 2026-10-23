@extends('layouts.app')

@section('title', 'Cursos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Cursos</h1>
    <a href="{{ route('courses.create') }}" class="btn btn-success">Nuevo Curso</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Número de Curso</th>
                    <th>Día</th>
                    <th>Área</th>
                    <th>Centro de Formación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>{{ data_get($course, 'id') }}</td>
                        <td>{{ data_get($course, 'course_number') }}</td>
                        <td>{{ data_get($course, 'day') }}</td>
                        <td>{{ data_get($course, 'area.nombre', 'N/A') }}</td>
                        <td>{{ data_get($course, 'trainingCenter.name', 'N/A') }}</td>
                        <td>
                            <a href="{{ route('courses.edit', data_get($course, 'id')) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('courses.destroy', data_get($course, 'id')) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar este curso?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No hay cursos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
