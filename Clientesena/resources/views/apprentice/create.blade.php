@extends('layouts.app')

@section('title', 'Nuevo Aprendiz')

@section('content')
<div class="card">
    <div class="card-header"><h1>Registrar Aprendiz</h1></div>
    <div class="card-body">
        <form action="{{ route('api.v1.apprentices.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('apprentice.form', ['apprentice' => null, 'photoUrl' => null])
            <a href="{{ route('api.v1.apprentices.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
</div>
@endsection
