@extends('layouts.app')

@section('title', 'Editar asignación')

@section('content')
<div class="card">
    <div class="card-header"><h1>Editar asignación</h1></div>
    <div class="card-body">
        <form action="{{ route('api.v1.course_teachers.update', data_get($courseTeacher, 'id')) }}" method="POST">
            @csrf
            @method('PUT')
            @include('course_teacher.form')
            <a href="{{ route('api.v1.course_teachers.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Actualizar</button>
        </form>
    </div>
</div>
@endsection
