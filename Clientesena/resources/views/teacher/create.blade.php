@extends('layouts.app')

@section('title', 'Nuevo Instructor')

@section('content')
<div class="card">
    <div class="card-header"><h1>Registrar Instructor</h1></div>
    <div class="card-body">
        <form action="{{ route('teachers.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">Nombre</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')<div class="text-danger">{{ $message }}</div>@enderror
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
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
</div>
@endsection
