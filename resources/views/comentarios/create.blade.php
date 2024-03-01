@extends('layouts.plantilla')
@section('titulo', 'Nueva Incidencia')
@section('contenido')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear incidencia</li>
        </ol>
    </nav>

    <h1 class="text-center">Nueva incidencia</h1>


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
        <form action="{{ route('comentario.store',$incidencia) }}" method="POST" class="form-horizantal">
            @csrf
            <div class="col-sm-12">
                <label for="texto" class="form-label">Texto:</label>
                <textarea id="texto" name="texto" col="10" rows="10" placeholder="Introduce aqui tu comentario.">
                </textarea>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <input type="submit" id="crear "class="btn btn-primary col-sm-2 text-white" value="Crear Incidencia">
            </div>
        </form>
    </div>
@endsection
