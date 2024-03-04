@extends('layouts.plantilla')
@section('titulo', 'Detalle de equipo')
@section('contenido')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('equipos.index') }}">Equipos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver equipo</li>
        </ol>
    </nav>
    <div id="caja-formulario">
        <div>
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> {{ session('error') }}.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Confirmacion:</strong> {{ session('success') }}.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="row">
            <h1 class="text-2xl font-bold mx-8 col-10">Equipo Nº {{ $equipo->etiqueta }}</h1>
            <div class="col-2">
                <a id="botonCrear" href="{{ route('equipos.edit', $equipo) }}">
                    <div class="svg-wrapper-1">
                        <div class="svg-wrapper">
                            <?xml version="1.0" ?><svg class="feather feather-edit" fill="none" height="24"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </div>
                    </div>
                    <span>Editar Equipo</span>
                </a>
            </div>
        </div>



        <div class="col-md-12">

            <div class="project-info-box mt-0">
                <h5>DESCRIPCION</h5>
                <p class="descripcion">{{ $equipo->descripcion }}</p>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <p class="col-sm-4"><strong>Tipo de equipo:</strong> {{ $equipo->tipo_equipo }}</p>
                    </div>
                    <p> <strong>Aula:</strong>
                        {{ $equipo->aula->codigo }}
                    </p>
                    <p><strong>Fecha:</strong> {{ $equipo->fecha_adquisicion }}</p>
                    <p><strong>Marca:</strong> {{ $equipo->marca }}</p>
                    <p><strong>Modelo:</strong> {{ $equipo->modelo }}</p>
                    <p><strong>Puesto:</strong> {{ $equipo->puesto }}</p>
                </div>
            </div>
        </div>
    </div>



    </div>




@endsection