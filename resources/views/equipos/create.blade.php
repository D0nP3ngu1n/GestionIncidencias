@extends('layouts.plantilla')
@section('titulo', 'Nuevo Equipo')
@section('contenido')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('equipos.index') }}">Equipos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear equipo</li>
        </ol>
    </nav>

    <h1 class="text-center">Nuevo Equipo</h1>


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


    <div id="caja-formulario" class="container">
        <form action="{{ route('equipos.store') }}" method="POST" enctype="multipart/form-data" class="form-horizantal">
            @csrf
            <div class="col-sm-12">
                <label for="nombre" class="form-label">Tipo de equipo:</label>
                <select id="departamento" name="departamento" class="form-select">
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo }}">{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="fecha_adquisicion" class="form-label col-sm-4">Fecha de adquisicion:</label>
                        <div class="col-sm-12">
                            <input type="date" id="fecha_adquisicion" name="fecha_adquisicion" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 ">
                    <div class="form-group">
                        <label for="etiqueta" class="form-label col-sm-4">Etiqueta:</label>
                        <div class="col-sm-12">
                            <input type="text" id="etiqueta" name="etiqueta" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="form-group">
                        <label for="marca" class="form-label col-sm-4">Marca:</label>
                        <div class="col-sm-12">
                            <input type="text" id="marca" name="marca"class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label for="modelo" class="form-label col-sm-4">Modelo:</label>
                    <div class="col-sm-12">
                        <input type="text" id="modelo" name="modelo"class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="form-outline col-sm-12">
                    <label for="descripcion" class="form-label">Descripcion:</label>
                    <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
                </div>
            </div>
    <div class="row invisible" id="info-equipo">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="aula" class="form-label col-sm-4">Aula:</label>
                <div class="col-sm-12">

                    <select id="aula" name="aula" class="form-select">
                        <option  value="null" selected>...</option>
                        @foreach ($aulas as $aula)
                            <option value="{{ $aula->num }}">{{ $aula->codigo }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="puesto" class="form-label col-sm-4">Puesto en el aula:</label>
                <input type="number" id="puesto" name="puesto" class="form-control">
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <input type="submit" id="crear "class="btn btn-primary col-sm-2 text-white" value="Crear Equipo">
    </div>
    </form>
    </div>
@endsection
