@extends('layouts.app')

@section('title', 'Detalle del Área')

@section('content')

@php
    $id = is_array($area) ? ($area['id'] ?? '') : ($area->id ?? '');
    $nombre = is_array($area) ? ($area['nombre'] ?? '') : ($area->nombre ?? '');
    $descripcion = is_array($area) ? ($area['descripcion'] ?? '') : ($area->descripcion ?? '');
@endphp

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1>Detalle del Área</h1>
        <a href="{{ route('areas.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>

    <div class="card-body">
        <p><strong>ID:</strong> {{ $id }}</p>
        <p><strong>Nombre:</strong> {{ $nombre }}</p>
        <p><strong>Descripción:</strong> {{ $descripcion ?: 'Sin descripción' }}</p>
    </div>
</div>

@endsection
