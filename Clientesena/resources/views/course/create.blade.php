@extends('layouts.app')

@section('title', 'Nuevo Curso')

@section('content')
<div class="card">
    <div class="card-header"><h1>Registrar Curso</h1></div>
    <div class="card-body">
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="course_number">Número de Curso</label>
                <input id="course_number" type="text" name="course_number" class="form-control" value="{{ old('course_number') }}" required>
                @error('course_number')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="day">Día</label>
                <input id="day" type="text" name="day" class="form-control" value="{{ old('day') }}" required>
                @error('day')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="area_id">Área</label>
                <select id="area_id" name="area_id" class="form-select" required>
                    <option value="">-- Seleccione un área --</option>
                    @foreach($areas as $area)
                        <option value="{{ data_get($area, 'id') }}" @selected(old('area_id') == data_get($area, 'id'))>{{ data_get($area, 'nombre') }}</option>
                    @endforeach
                </select>
                @error('area_id')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="training_center_id">Centro de Formación</label>
                <select id="training_center_id" name="training_center_id" class="form-select" required>
                    <option value="">-- Seleccione un centro --</option>
                    @foreach($trainingCenters as $center)
                        <option value="{{ data_get($center, 'id') }}" @selected(old('training_center_id') == data_get($center, 'id'))>{{ data_get($center, 'name') }}</option>
                    @endforeach
                </select>
                @error('training_center_id')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
</div>
@endsection
