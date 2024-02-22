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

    <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" id="nombre" class="form-control">
        </div>
        <div class="mb-3">
            <label for="apellido1" class="form-label">Primer Apellido:</label>
            <input type="text" id="apellido1" class="form-control">
        </div>
        <div class="mb-3">
            <label for="apellido2" class="form-label">Segundo Apellido:</label>
            <input type="text" id="apellido2" class="form-control">
        </div>
        <div class="mb-3">
            <label for="correo_asociado" class="form-label">Correo electrónico:</label>
            <input type="correo_asociado" id="" class="form-control">
        </div>
        <div class="mb-3">
            <label for="departamento" class="form-label">Departamento:</label>
            <input type="text" id="departamento" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label"></label>
            <select id="tipo" class="form-select">
                <option value="EQUIPOS">Equipos</option>
                <option value="CUENTAS">Cuentas</option>
                <option value="WIFI">Wifi</option>
                <option value="SOFTWARE">Software</option>
            </select>
        </div>
        <div id="caja_subtipo"class="mb-3 invisible">
            <label for="subtipo" class="form-label">Subtipo:</label>
            <select id="subtipo" class="form-select">
        </div>
        <div id="caja_sub_subtipo"class="mb-3 invisible">
            <label for="sub_subtipo" class="form-label"></label>
            <select id="sub_subtipo" class="form-select">
        </div>
        <script>
            window.addEventListener('load', inicio, false);

            function inicio() {
                document.getElementById
            }
        </script>
        <div class="mb-3">
            <label for="" class="form-label"></label>
            <input type="" id="" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label"></label>
            <input type="" id="" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label"></label>
            <input type="" id="" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label"></label>
            <input type="" id="" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label"></label>
            <input type="" id="" class="form-control">
        </div>

    </form>
