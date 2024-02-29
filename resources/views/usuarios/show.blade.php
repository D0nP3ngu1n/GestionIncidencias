@extends('layouts.plantilla')
@section('titulo', 'Detalle de usuario')
@section('contenido')


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

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Listado usuarios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ver usuario</li>
            </ol>
        </nav>
        <div class="border-1 rounded-4 p-2 ">
            <div class="row my-3 py-3 w-auto rounded-4 bg-colorSecundario">
                <h1 class="text-2xl font-bold mx-8 col-10">Listado de usuario</h1>
                <div class="col -2">
                    <a id="botonCrear" href="{{ route('usuarios.edit', $usuario) }}">
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
                        <span>Editar usuario</span>
                    </a>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="project-info-box mt-0">
                    <h5>{{ $usuario->nombre_completo }}</h5>
                </div>

                <div class="project-info-box">
                    <p> <strong>Departamento de usuario:</strong> @empty($usuario->departamento)
                            Todavía no asignado
                        @else
                            {{ $usuario->departamento->nombre }}
                        @endempty
                    </p>
                    <p><strong>Email de usuario:</strong> {{ $usuario->email }}</p>
                </div>
            </div>
        </div>
    </div>
    {{--
    <div class="mt-3 p-3 w-auto rounded-4 bg-colorSecundario">
        <h1>Comentarios</h1>
        <ul class="list-unstyled">
            @empty($incidencia->comentarios)
                <div class="d-flex justify-content-center">
                    <h3>Todavia no hay comentarios</h3>
                </div>

            @else
                @foreach ($incidencia->comentarios as $comentario)
                    <li class="d-flex justify-content-between mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between p-3">
                                <p class="fw-bold mb-0 mx-2">{{ $comentario->persona->nombreCompleto }}</p>
                                <p class="text-muted small mb-0"><i class="far fa-clock"></i> {{ $comentario->getFecha() }}
                                    dias</p>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">
                                    {{ $comentario->texto }}
                                </p>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endempty

            </ul>

        </div>
        </div> --}}


@endsection
