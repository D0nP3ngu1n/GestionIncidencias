@extends('layouts.plantilla')
@section('titulo', 'Nueva Incidencia')
@section('contenido')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear comentario</li>
        </ol>
    </nav>

    <h1 class="text-center">Nuevo comentario</h1>


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
                <textarea id="texto" name="texto" cols="66" rows="2" placeholder="Introduce aqui tu comentario.">
                </textarea>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <input type="submit" id="crear "class="btn btn-primary col-sm-2 text-white" value="Crear comentario">
            </div>
        </form>
    </div>
@endsection
