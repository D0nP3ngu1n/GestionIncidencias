@extends('layouts.plantilla')
@section('titulo', 'Detalle de Incidencia')
@section('contenido')
    <h1>Detalle de la incidencia {{ $incidencia->num }}</h1>
    <div class="container">
        <p>
            Numero de la incidencia: {{ $incidencia->num }}
            Tipo de la incidencia: {{ $incidencia->tipo }}
            {{ $subtipo = IncidenciaSubtipo::where('id', $incidencia->subtipo_id) }}
            Subtipo:{{ $subtipo->subtipo_nombre }}
            Sub-subtipo:{{ $subtipo->sub_subtipo }}
            Descripcion:{{ $incidencia->descripcion }}
            Estado:{{ $incidencia->estado }}
            {{ $persona = Persona::where('id', $incidencia->creador_id) }}
            Creador:{{ $persona->nombre + ', ' + $persona->apellido1 + ' ' + $persona->apellido2 }}
            {{ $responsable = Persona::where('id', $incidencia->responsable_id) }}
            Responsable:{{ $responsable->nombre + ', ' + $responsable->apellido1 + ' ' + $responsable->apellido2 }}
            Fecha de creación:{{ $incidencia->fecha_creacion }}
            Fecha de cierre:{{ $incidencia->fecha_cierre }}
        </p>
    </div>
