<div>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
</div>
@extends('layouts.plantilla')
@section('titulo', 'Nuevo Usuario')
@section('contenido')
    <h1>Nuevo usuario</h1>

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

    <form action="{{ route('usuarios.update', $usuario) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="nombreCompleto" class="form-label">Nombre completo:</label>
            <input type="text" id="nombreCompleto" name="nombreCompleto" class="form-control"
                value="{{ $usuario->nombreCompleto }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">email:</label>
            <input type="text" id="email" name="email" class="form-control" value="{{ $usuario->email }}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" id="password" name="password" class="form-control" value="{{ $usuario->password }}">
        </div>
        <div class="mb-3">
            <label for="departamento_id" class="form-label">Departamentos</label>
            <select id="departamento_id" name="departamento_id" class="form-select">
                <option selected="true">...</option>
                @foreach ($departamentos as $departamento)
                    @if ($departamento->nombre == $departamentoUsuario)
                        <option value="{{ $departamento->id }}" selected>{{ $departamento->nombre }}</option>
                    @else
                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <input type="submit" id="crear "class="btn btn-outline-primary col" value="Crear Incidencia">
    </form>
@endsection
