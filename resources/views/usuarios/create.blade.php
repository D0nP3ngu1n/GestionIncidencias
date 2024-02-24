@extends('layouts.plantilla')
@section('titulo', 'Nueva Incidencia')
@section('contenido')
    <h1>Nueva incidencia</h1>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Hubo errores en el formulario:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nombreCompleto" class="form-label">Nombre completo:</label>
            <input type="text" id="nombreCompleto" name="nombreCompleto" class="form-control">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">email:</label>
            <input type="text" id="email" name="email" class="form-control" placeholder="email acabado con @educantabria.es">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="minimo 8 caracteres">
        </div>
        <div class="mb-3">
            <label for="departamento_id" class="form-label">Departamentos</label>
            <select id="departamento_id" name="departamento_id" class="form-select">
                <option selected="true">...</option>
                @foreach ($departamentos as $departamento)
                <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                @endforeach
            </select>
        </div>
        <input type="submit" id="crear "class="btn btn-outline-primary col" value="Crear Incidencia">
    </form>
@endsection

