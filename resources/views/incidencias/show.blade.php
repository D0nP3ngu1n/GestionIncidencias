@extends('layouts.plantilla')
@section('titulo', 'Detalle de Incidencia')
@section('contenido')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver incidencia</li>
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
            <h1 class="text-2xl font-bold mx-8 col-10">INCIDENCIA Nº {{ $incidencia->id }}</h1>
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
                        <span>Editar Incidencia </span>
                    </a>
                </div>
            @endhasrole
        </div>



        <div class="col-md-12">

            <div class="project-info-box mt-0">
                <h5>DESCRIPCION</h5>
                <p class="descripcion">{{ $incidencia->descripcion }}</p>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <p class="col-sm-4"><strong>Tipo de la incidencia:</strong> {{ $incidencia->tipo }}</p>
                        @if ($incidencia->subtipo != null)
                            <p class="col-sm-3"><strong>Subtipo:</strong> {{ $incidencia->subtipo->subtipo_nombre }}</p>
                            @if ($incidencia->subtipo->sub_subtipo != null)
                                <p class="col-sm-4"><strong>Sub-Subtipo:</strong> {{ $incidencia->subtipo->sub_subtipo }}
                                </p>
                            @endif
                        @endif
                    </div>
                    <p> <strong>Responsable:</strong>
                        @empty($incidencia->responsable_id)
                            todavia no asignada
                        @else
                            {{ $incidencia->responsable->nombre }}, {{ $incidencia->responsable->apellido1 }}
                            {{ $incidencia->responsable->apellido2 }}
                        @endempty
                    </p>
                    <p><strong>Estado:</strong> {{ $incidencia->estado }}</p>
                    <div class="row">
                        <p class="col-sm-5"><strong>Fecha de creación:</strong> {{ $incidencia->fecha_creacion }} </p>
                        <p class="col-sm-5"><strong>Fecha de cierre:</strong>
                            {{ $incidencia->fecha_cierre ?? 'No cerrada' }}
                        </p>
                    </div>
                </div>
                <div class="col-md-4 row-end-12">
                    <p><strong>Archivos:</strong></p>
                    <div class="caja-archivos col-md-12 rw-md-12">
                        <div id="simbolo"></div>
                        <a href="{{ route('descargar.archivo', ['incidencia' => $incidencia]) }}"
                            id="ruta">{{ $incidencia->adjunto_url }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var cadena = document.getElementById('ruta').textContent;
        console.log(cadena);

        function obtenerContenidoDesdeCaracter(cadena) {
            const indiceCaracter = cadena.indexOf('.');
            if (indiceCaracter !== -1) {
                const contenidoDesdeCaracter = cadena.substring(indiceCaracter + 1);
                return contenidoDesdeCaracter;
            } else {
                console.error(`El carácter "${caracter}" no se encontró en la cadena.`);
                return null;
            }
        }
        var opc = obtenerContenidoDesdeCaracter(cadena);
        switch (opc) {
            case "jpg":
                document.getElementById('simbolo').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                                                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
                                                                </svg>`;
                break;
            case "pdf":
                document.getElementById('simbolo').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                                                                    </svg>`;
                break;
            case "csv":
                document.getElementById('simbolo').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-spreadsheet-fill" viewBox="0 0 16 16">
                                                                <path d="M12 0H4a2 2 0 0 0-2 2v4h12V2a2 2 0 0 0-2-2m2 7h-4v2h4zm0 3h-4v2h4zm0 3h-4v3h2a2 2 0 0 0 2-2zm-5 3v-3H6v3zm-4 0v-3H2v1a2 2 0 0 0 2 2zm-3-4h3v-2H2zm0-3h3V7H2zm4 0V7h3v2zm0 1h3v2H6z"/>
                                                                </svg>`;
                break;
            case "rtf":
                document.getElementById('simbolo').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-earmark-word-fill" viewBox="0 0 16 16">
                                                                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M5.485 6.879l1.036 4.144.997-3.655a.5.5 0 0 1 .964 0l.997 3.655 1.036-4.144a.5.5 0 0 1 .97.242l-1.5 6a.5.5 0 0 1-.967.01L8 9.402l-1.018 3.73a.5.5 0 0 1-.967-.01l-1.5-6a.5.5 0 1 1 .97-.242z"/>
                                                                </svg>`;
                break;
        }
    </script>

    <div class="mt-3 p-3 w-auto rounded-4 bg-colorSecundario">
        <div class="row">
            <h1 class="col">Comentarios</h1>
            <div class="col-2">

                <a id="botonCrear" href="{{ route('comentario.create', $incidencia) }}">
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

                            <div class="card-header d-flex justify-content-between p-3 ">

                                <p class="fw-bold mb-0 mx-2">{{ $comentario->user->nombre_completo }}</p>
                                <p class="text-muted small mb-0"><i class="far fa-clock"></i>
                                    {{ $comentario->getFecha() }}
                                    dias</p>
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

    </div>
    </div>





@endsection
