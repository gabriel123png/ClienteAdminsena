@extends('layouts.app')

@section('title', 'Asignaciones de cursos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Asignaciones de cursos</h1>
    <a href="{{ route('course_teachers.create') }}" class="btn btn-success">Asignar instructor</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead><tr><th>ID</th><th>Curso</th><th>Instructor</th><th>Acciones</th></tr></thead>
            <tbody>
                @forelse($courseTeachers as $assignment)
                    <tr>
                        <td>{{ data_get($assignment, 'id') }}</td>
                        <td>{{ data_get($assignment, 'course.course_number', 'N/A') }}</td>
                        <td>{{ data_get($assignment, 'teacher.name', 'N/A') }}</td>
                        <td>
                            <a href="{{ route('course_teachers.edit', data_get($assignment, 'id')) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('course_teachers.destroy', data_get($assignment, 'id')) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar esta asignación?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">No hay asignaciones registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
