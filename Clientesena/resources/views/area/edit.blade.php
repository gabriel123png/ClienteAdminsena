@extends('layouts.app')

@section('title', 'Editar Área')

@section('content')

<div class="card">

    <div class="card-header">
        <h1>Editar Área</h1>
    </div>

    <div class="card-body">

        @php
            $id = is_array($area) ? ($area['id'] ?? '') : ($area->id ?? '');
            $nombre = is_array($area) ? ($area['nombre'] ?? '') : ($area->nombre ?? '');
            $descripcion = is_array($area) ? ($area['descripcion'] ?? '') : ($area->descripcion ?? '');
        @endphp

        <form
            action="{{ route('areas.update', $id) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">
                    Nombre
                </label>
                <input
                    type="text"
                    name="nombre"
                    class="form-control"
                    value="{{ old('nombre', $nombre) }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Descripción
                </label>
                <textarea
                    name="descripcion"
                    class="form-control"
                    rows="4">{{ old('descripcion', $descripcion) }}</textarea>
            </div>

            <a
                href="{{ route('areas.index') }}"
                class="btn btn-secondary">
                Cancelar
            </a>

            <button
                type="submit"
                class="btn btn-warning">
                Actualizar
            </button>

        </form>

    </div>

</div>

@endsection