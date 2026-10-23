@extends('layouts.app')

@section('title', 'Detalle del Computador')

@section('content')

@php
    $id = is_array($computer) ? ($computer['id'] ?? '') : ($computer->id ?? '');
    $number = is_array($computer) ? ($computer['number'] ?? '') : ($computer->number ?? '');
    $brand = is_array($computer) ? ($computer['brand'] ?? '') : ($computer->brand ?? '');
@endphp

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1>Detalle del Computador</h1>
        <a href="{{ route('computers.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>

    <div class="card-body">
        <p><strong>ID:</strong> {{ $id }}</p>
        <p><strong>Número:</strong> {{ $number }}</p>
        <p><strong>Marca:</strong> {{ $brand }}</p>
    </div>
</div>

@endsection
