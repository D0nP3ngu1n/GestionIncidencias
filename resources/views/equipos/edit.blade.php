@extends('layouts.plantilla')
@section('titulo', 'Editar Equipo')
@section('contenido')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('equipos.index') }}">Equipos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Equipo</li>
        </ol>
    </nav>

    <h1 class="text-center">Editar Equipo Nº {{$equipo->etiqueta}}</h1>


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
        <form action="{{ route('equipos.update',$equipo) }}" method="POST" enctype="multipart/form-data" class="form-horizantal">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-sm-6">
                    <label for="departamento" class="form-label col-sm-4">aula:</label>

                    <select id="aula_num" name="aula_num" class="form-select">
                        @foreach ($aulas as $aula)
                            <option value="{{ $aula->num }}">{{ $aula->codigo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="tipo_equipo" class="form-label col-sm-4">Tipo de equipo:</label>
                    <select id="tipo_equipo" name="tipo_equipo" class="form-select">
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo }}">{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="fecha_adquisicion" class="form-label">Fecha de adquisicion:</label>
                    <input type="date" id="fecha_adquisicion" name='fecha_adquisicion' value="{{$equipo->fecha_adquisicion}}" class="form-control">
                </div>

                <div class="col-sm-4">
                    <label for="etiqueta" class="form-label">Etiqueta:</label>
                    <input type="text" id="etiqueta" name='etiqueta' placeholder="etiqueta" value="{{$equipo->etiqueta}}" class="form-control">
                </div>
                <div class="col-sm-4">
                    <label for="marca" class="form-label">Marca:</label>
                    <input type="text" id="marca" name='marca' placeholder="marca" value="{{$equipo->marca}}" class="form-control">
                </div>
            </div>


            <div class="form-outline col-sm-12">
                <label for="descripcion" class="form-label">Descripcion:</label>
                <textarea id="descripcion" name="descripcion" class="form-control"> {{$equipo->descripcion}}</textarea>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="modelo" class="form-label">modelo:</label>
                    <input type="text" id="modelo" name='modelo' placeholder="modelo" value="{{$equipo->modelo}}" class="form-control">
                </div>
                <div class="col-sm-4">
                    <label for="puesto" class="form-label">puesto:</label>
                    <input type="number" id="puesto" name='puesto' min="0" max="100" value="{{$equipo->puesto}}" class="form-control">
                </div>
                <div class="col-sm-4">
                    <label for="activo" class="form-label">activo:</label>
                    <select name="baja" id="baja" required class="form-select">
                        <option value="1">activo</option>
                        <option value="">baja</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <input type="submit" id="crear "class="btn btn-primary col-sm-2 text-white" value="Editar Equipo">
            </div>
        </form>
    </div>
@endsection
