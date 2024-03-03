@extends('layouts.plantilla')
@section('titulo', 'Crear un aula')
@section('contenido')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('aulas.index') }}">Aulas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear Aulas</li>
        </ol>
    </nav>

    <h1 class="text-center">Nueva Aula</h1>


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
        <form action="{{ route('aulas.store') }}" method="POST" enctype="multipart/form-data" class="form-horizantal">
            @csrf
            <div class="row">
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <label for="codigo" class="form-label">Codigo:</label>
                            <div class="col-sm-12">

                                <input type="text" id="codigo" name="codigo" class="form-control" placeholder="codigo">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <label for="planta" class="form-label">Planta:</label>
                            <div class="col-sm-12">
                                <input type="number" min="0" max="3" id="planta" name="planta" class="form-control" placeholder="planta" value="0">
                            </div>
                        </div>
                    </div>

            </div>
            <div class="form-outline col-sm-12">
                <label for="descripcion" class="form-label">Descripcion:</label>
                <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <input type="submit" id="crear "class="btn btn-primary col-sm-2 text-white" value="Crear Aula">
            </div>
        </form>
    </div>
@endsection
