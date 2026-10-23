@extends('layouts.app')

@section('title', 'Editar Computador')

@section('content')

<div class="card">

    <div class="card-header">
        <h1>Editar Computador</h1>
    </div>

    <div class="card-body">

        @php
            $id = is_array($computer) ? ($computer['id'] ?? '') : ($computer->id ?? '');
            $number = is_array($computer) ? ($computer['number'] ?? '') : ($computer->number ?? '');
            $brand = is_array($computer) ? ($computer['brand'] ?? '') : ($computer->brand ?? '');
        @endphp

        <form action="{{ route('computers.update', $id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label">
                    Número
                </label>

                <input
                    type="text"
                    name="number"
                    class="form-control"
                    value="{{ old('number', $number) }}"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Marca
                </label>

                <input
                    type="text"
                    name="brand"
                    class="form-control"
                    value="{{ old('brand', $brand) }}"
                    required>

            </div>

            <a
                href="{{ route('computers.index') }}"
                class="btn btn-secondary">

                Cancelar

            </a>

            <button
                type="submit"
                class="btn btn-success">

                Actualizar

            </button>

        </form>

    </div>

</div>

@endsection