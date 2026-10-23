@extends('layouts.app')

@section('title', 'Detalle del Centro de Formación')

@section('content')

@php
    $id = is_array($trainingCenter) ? ($trainingCenter['id'] ?? '') : ($trainingCenter->id ?? '');
    $name = is_array($trainingCenter) ? ($trainingCenter['name'] ?? '') : ($trainingCenter->name ?? '');
    $location = is_array($trainingCenter) ? ($trainingCenter['location'] ?? '') : ($trainingCenter->location ?? '');
@endphp

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1>Detalle del Centro de Formación</h1>
        <a href="{{ route('api.v1.training_centers.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>

    <div class="card-body">
        <p><strong>ID:</strong> {{ $id }}</p>
        <p><strong>Nombre:</strong> {{ $name }}</p>
        <p><strong>Ubicación:</strong> {{ $location }}</p>
    </div>
</div>

@endsection
