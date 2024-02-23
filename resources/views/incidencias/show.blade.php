@extends('layouts.plantilla')
@section('titulo', 'Detalle de Incidencia')
@section('contenido')

<div class="container background-color-grey-light">
    <div class="row">
        <div class="col-md-5">
            <div class="project-info-box mt-0">
                <h5>DESCRIPCION</h5>
                <p class="mb-0">{{ $incidencia->descripcion }}</p>
            </div>

            <div class="project-info-box">
                <p> <strong>Numero de la incidencia:</strong> {{ $incidencia->num }}</p>
                <p><strong>Tipo de la incidencia:</strong> {{ $incidencia->tipo }}</p>
                <p><strong>Subtipo:</strong> {{ $incidencia->subtipo->nombre }}</p>
                <p><strong>Descripción:</strong> {{ $incidencia->descripcion }} </p>
                <p ><strong>Estado:</strong> {{ $incidencia->estado }}</p>
                <strong >Fecha de creación:</strong> {{ $incidencia->fecha_creacion }} <br>
                <strong>Fecha de cierre:</strong> {{ $incidencia->fecha_cierre ?? 'No cerrada' }} <br>
            </div>

        </div>

        <div class="col-md-7">
            <img src="https://www.bootdey.com/image/400x300/FFB6C1/000000" alt="project-image" class="rounded">
            <div class="project-info-box">
                <p><b>r:</b> Design, Illustration</p>
                <p> <strong>Responsable:</strong>
                    @empty($incidencia->responsable_id)
                        todavia no asignada
                    @else
                        {{ $incidencia->responsable->nombre }}, {{ $incidencia->responsable->apellido1 }} {{ $incidencia->responsable->apellido2 }}
                    @endempty</p>
            </div>
        </div>
    </div>
</div>
@endsection
