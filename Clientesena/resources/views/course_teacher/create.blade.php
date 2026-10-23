@extends('layouts.app')

@section('title', 'Asignar instructor')

@section('content')
<div class="card">
    <div class="card-header"><h1>Asignar instructor a un curso</h1></div>
    <div class="card-body">
        <form action="{{ route('api.v1.course_teachers.store') }}" method="POST">
            @csrf
            @include('course_teacher.form', ['courseTeacher' => null])
            <a href="{{ route('api.v1.course_teachers.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
</div>
@endsection
