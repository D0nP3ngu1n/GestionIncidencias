@extends('layouts.plantilla')
@section('titulo', 'Edición de Incidencias')
@section('contenido')
    <h1>Edición de la incidencia {{ $incidencia->num }}</h1>
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
    <form action="{{ route('incidencias.update', $incidencia) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="{{ $incidencia->creador->nombre_completo }}"
                class="form-control">
        </div>

        <div class="mb-3">
            <label for="correo_asociado" class="form-label">Correo electrónico:</label>
            <input type="correo_asociado" id="correo" name="correo"
                value="{{ $incidencia->creador->email }}"class="form-control">
        </div>
        <div class="mb-3">
            <label for="departamento" class="form-label">Departamento:</label>
            <input type="text" id="departamento" name="departamento"
                value="{{ $incidencia->creador->departamento->nombre }}" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo:</label>
            <input type="text" id="tipo" name="tipo" class="form-control" value="{{ $incidencia->tipo }}"
                disabled>
        </div>
        <div id="sel1"class="mb-3">
            <label for="subtipo" class="form-label">Subtipo:</label>
            <input type="text" id="subtipo" name="subtipo" class="form-control"
                value="{{ $incidencia->subtipo->subtipo_nombre }}" disabled>
        </div>
        <div id="sel2"class="mb-3">
            <label for="sub_subtipo" class="form-label">Sub_subtipo</label>
            <input type="text" id="sub_subtipo" name="sub_subtipo" class="form-select"
                value="{{ $incidencia->subtipo->sub_subtipo ?? 'No tiene subtipo' }}" disabled>
        </div>
        <div class="mb-3">
            <label for="numero_etiqueta" class="form-label">Etiqueta del equipo:</label>
            <input type="text" id="numero_etiqueta" name="numero_etiqueta" class="form-control"
                value="{{ $incidencia->equipo->etiqueta ?? 'No es una incidencia de equipo' }}" disabled>
        </div>
        <div class="mb-3">
            <label for="aula" class="form-label">Aula:</label>
            <input type="text" id="aula" name="aula" class="form-control"
                value="{{ $incidencia->equipo->aula->codigo ?? 'No existe la etiqueta' }}" disabled>
        </div>
        <div class="mb-3">
            <label for="puesto" class="form-label">Puesto en el aula:</label>
            <input type="text" id="puesto" name="puesto" class="form-control"
                value="{{ $incidencia->equipo->puesto }}" disabled>
        </div>
        <div class="form-outline">
            <label for="descripcion" class="form-label">Descripcion:</label>
            <textarea id="descripcion" name="descripcion" class="form-control" value="{{ $incidencia->descripcion }}"></textarea>
        </div>
        <div class="mb-3">
            <label for="adjunto" class="form-label">Archivo Adjunto:</label>
            <input type="file" id="adjunto" name="adjunto" class="form-control" value="{{ $incidencia->adjunto_url }}"
                disabled>
        </div>
        <div class="mb-3">
            <label for="responsable" class="form-label">Responsable:</label>
            <select id="responsable" name="responsable" class="form-select">
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->nombre_completo }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado:</label>
            <select id="estado" name="estado" class="form-select">
                <option value="{{ $incidencia->estado }}">{{ $incidencia->estado }}</option>
                <option value="abierta">Abierta</option>
                <option value="asignada">Asignada</option>
                <option value="en proceso">En proceso</option>
                <option value="enviada a Infortec">Enviada a Infortec</option>
                <option value="resuelta">Resuelta</option>
                <option value="cerrada">Cerrada</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="prioridad" class="form-label">Prioridad:</label>
            <select id="prioridad" name="prioridad" class="form-select">
                <option value="{{ $incidencia->prioridad }}">{{ $incidencia->prioridad }}</option>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
            </select>
        </div>
        <div>
            <label for="fecha_creacion" class="form-label">Fecha de Creacion:</label>
            <input type="date" value="{{ $incidencia->fecha_creacion }}" id="fecha_creacion" name="fecha_creacion"
                class="form-control">
        </div>
        <div>
            <label for="fecha_cierre" class="form-label">Fecha de cierre</label>
            <input type="date" value="{{ $incidencia->fecha_cierre ?? 'No se ha cerrado la incidencia' }}"
                id="fecha_cierre" name="fecha_cierre">
        </div>
        <input type="submit" id="crear "class="btn btn-outline-primary col" value="Editar Incidencia">
        <script>
            var valor = document.getElementById('estado').se;
            console.log('estado');
        </script>
    </form>
@endsection
