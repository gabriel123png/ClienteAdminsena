@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2>Editar Centro de Formación</h2>

    @php
        $id = is_array($trainingCenter) ? ($trainingCenter['id'] ?? '') : ($trainingCenter->id ?? '');
        $name = is_array($trainingCenter) ? ($trainingCenter['name'] ?? '') : ($trainingCenter->name ?? '');
        $location = is_array($trainingCenter) ? ($trainingCenter['location'] ?? '') : ($trainingCenter->location ?? '');
    @endphp

    <form action="{{ route('api.v1.training_centers.update', $id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre</label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $name) }}">

            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label class="form-label">Ubicación</label>

            <input type="text"
                   name="location"
                   class="form-control"
                   value="{{ old('location', $location) }}"
                   required>

            @error('location')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <button type="submit" class="btn btn-primary">
            Actualizar
        </button>

        <a href="{{ route('api.v1.training_centers.index') }}"
           class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>

@endsection