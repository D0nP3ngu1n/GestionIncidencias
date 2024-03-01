@extends('layouts.plantilla')
@section('titulo', 'Detalle de Incidencia')
@section('contenido')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('incidencias.index') }}">Incidencias</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver incidencia</li>
        </ol>
    </nav>
    <div class="p-3 w-auto rounded-4 bg-colorSecundario">
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


        <div class="border-1 rounded-4 p-2 ">
            <div class="row my-3 py-3 w-auto rounded-4 bg-colorSecundario">
                <h1 class="text-2xl font-bold mx-8 col-10">Listado de incidencias</h1>
                @hasrole('Administrador')
                    <div class="col-2">

                        <a id="botonCrear" href="{{ route('incidencias.edit', $incidencia) }}">
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
                            <span>Editar Incidencia Incidencia</span>
                        </a>
                    </div>
                @endhasrole
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="project-info-box mt-0">
                    <h5>DESCRIPCION</h5>
                    <p class="mb-0">{{ $incidencia->descripcion }}</p>
                </div>

                <div class="project-info-box">
                    <p> <strong>Numero de la incidencia:</strong> {{ $incidencia->num }}</p>
                    <p><strong>Tipo de la incidencia:</strong> {{ $incidencia->tipo }}</p>
                    <p><strong>Subtipo:</strong> {{ $incidencia->subtipo->subtipo_nombre }}</p>
                    <p><strong>Descripción:</strong> {{ $incidencia->descripcion }} </p>
                    <p><strong>Estado:</strong> {{ $incidencia->estado }}</p>
                    <strong>Fecha de creación:</strong> {{ $incidencia->fecha_creacion }} <br>
                    <strong>Fecha de cierre:</strong> {{ $incidencia->fecha_cierre ?? 'No cerrada' }} <br>
                </div>
            </div>

            <div class="col-md-7">
                <img src="https://www.bootdey.com/image/400x300/FFB6C1/000000" alt="project-image" class="rounded">
                <div class="project-info-box">
                    <p> <strong>Responsable:</strong>
                        @empty($incidencia->responsable_id)
                            todavia no asignada
                        @else
                            {{ $incidencia->responsable->nombre }}, {{ $incidencia->responsable->apellido1 }}
                            {{ $incidencia->responsable->apellido2 }}
                        @endempty
                    </p>
                    <a href="{{ route('descargar.archivo', ['incidencia' => $incidencia]) }}">Descargar Archivo</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 p-3 w-auto rounded-4 bg-colorSecundario">
        <div class="row">
            <h1 class="col">Comentarios</h1>
            <div class="col-2">

                <a id="botonCrear" href="{{ route('comentario.create',$incidencia) }}">
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
                    <span>Crear Comentario</span>
                </a>
            </div>
        </div>


        <ul class="list-unstyled">
            @empty($incidencia->comentarios)
                <div class="d-flex justify-content-center">
                    <h3>Todavia no hay comentarios</h3>
                </div>
            @else
                @foreach ($incidencia->comentarios as $comentario)
                    <div class="d-flex justify-content-between my-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between p-3 " >
                                <p class="fw-bold mb-0 mx-2">{{ $comentario->user->nombre_completo }}</p>
                                <p class="text-muted small mb-0"><i class="far fa-clock"></i> {{ $comentario->getFecha() }}
                                    dias</p>
                                @hasrole('Administrador')
                                    <form action="{{ route('comentario.destroy',$comentario) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                @endhasrole
                            </div>

                            <div class="card-body">
                                <p class="mb-0">
                                    {{ $comentario->texto }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endempty

        </ul>

    </div>
    </div>





@endsection
