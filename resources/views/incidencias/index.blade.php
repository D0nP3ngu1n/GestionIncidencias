@extends('layouts.plantilla')
@section('titulo', 'Listar Incidencias')
@section('contenido')

    <div class="border-1 rounded-4 p-2 ">
        <div class="row my-3 py-3 w-auto rounded-4 bg-colorSecundario">
            <h1 class="text-2xl font-bold mx-8 col-10">Listado de incidencias</h1>
            <div class="col -2">
                <a id="botonCrear" href="{{ route('incidencias.create') }}">
                    <div class="svg-wrapper-1">
                        <div class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24"
                                fill="none" class="svg">
                                <line y2="19" y1="5" x2="12" x1="12"></line>
                                <line y2="12" y1="12" x2="19" x1="5"></line>
                            </svg>
                        </div>
                    </div>
                    <span>Crear Incidencia</span>
                </a>
            </div>
        </div>
    </div>

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



    <div class="bg-colorSecundario rounded-3 p-3">
        <!-- Filtros -->
        <form id="formFiltros" action='{{ route('incidencias.filtrar') }}' method="POST">
            @csrf
            <div class="row my-1 ">
                <div class="col-md-2">
                    <input type="text" id="descripcion" name="descripcion" class="form-control"
                        placeholder="Descripción">
                </div>
                <div class="col-md-2">
                    <input type="text" id="tipo" name="tipo" class="form-control" placeholder="Tipo">
                </div>

                <div class="col-md-2">
                    <input type="text" id="aula" name="aula" class="form-control" placeholder="Aula">
                </div>

                <div class="col-md-2">

                    <select name="estado" id="estado" class="form-control">
                        <option value="">--Estado--</option>
                        <option value="abierta">abierta</option>
                        <option value="en proceso">en proceso</option>
                        <option value="asignada">asignada</option>
                        <option value="enviada a Infortec">enviada a Infortec</option>
                        <option value="resuelta">resuelta</option>
                        <option value="cerrada">cerrada</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="text" id="creador" name="creador" class="form-control" placeholder="creador">
                </div>

                <div class="col-md-2">
                    <input type="text" id="responsable" name="responsable" class="form-control"
                        placeholder="Responsable">
                </div>

                <div class="col-md-2">
                    <select name="prioridad" id="prioridad" class="form-control">
                        <option value="">--Prioridad--</option>
                        <option value="alta">alta</option>
                        <option value="media">media</option>
                        <option value="baja">baja</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="desde">desde:</label>
                    <input type="date" id="desde" name="desde" class="form-control">
                </div>

                <div class="col-md-2">
                    <label for="hasta">hasta:</label>
                    <input type="date" id="hasta" name="hasta" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary text-white">Filtrar</button>
                </div>

            </div>
        </form>

        <!-- Desplegable de opciones para exportar -->
        <form id="exportForm" action="{{ route('exports.export') }}" method="POST">
            @csrf
            <label for="exportOption">Exportar como:</label>
            <select id="exportOption" name="exportOption">
                <option value="">--Elija una opción--</option>
                <option value="{{ route('exports.export') }}">Excel</option>
                <option value="{{ route('exports.pdf') }}">PDF</option>
                <option value="{{ route('exports.csv') }}">CSV</option>
            </select>
        </form>
        <script>
            document.getElementById('exportOption').addEventListener('change', function() {
                if (this.value !== '') {
                    document.getElementById('exportForm').action = this.value;
                    document.getElementById('exportForm').submit();
                }
            });
        </script>

        <!-- Fin Filtros -->
        <div class="d-flex flex-row gap-3 flex-wrap justify-content-center ">


            @if (count($incidencias) > 0)
                <table id="tablaIncidencias" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Aula</th>
                            <th scope="col">Creado por</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Prioridad</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($incidencias as $incidencia)
                            <tr class="align-middle" scope="row">
                                <td class="text-truncate">{{ $incidencia->id }}</td>
                                <td class="text-truncate">{{ $incidencia->fecha_creacion }}</td>
                                <td class="text-truncate" style="max-width: 150px;">{{ $incidencia->descripcion }}</td>
                                <td class="text-truncate">{{ $incidencia->tipo }}</td>
                                <td class="text-truncate">
                                    @empty($incidencia->equipo)
                                        Sin aula
                                    @else
                                        {{ $incidencia->equipo->aula->codigo }}
                                    @endempty
                                </td>
                                <td class="text-truncate">{{ $incidencia->creador->nombre_completo }}</td>
                                <td class="text-truncate">
                                    @empty($incidencia->responsable_id)
                                        Todavía no asignado
                                    @else
                                        {{ $incidencia->responsable_id }}
                                    @endempty
                                </td>
                                <td class="text-truncate">{{ $incidencia->estado }}</td>
                                <td class="text-truncate">
                                    @empty($incidencia->prioridad)
                                        Todavía no asignado
                                    @else
                                        {{ $incidencia->prioridad }}
                                    @endempty
                                </td>
                                <td class="text-truncate">
                                    <a href="{{ route('incidencias.show', $incidencia) }}"
                                        class="btn btn-primary text-white"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('incidencias.edit', $incidencia) }}"
                                        class="btn btn-success text-white"><i class="bi bi-pencil-square"></i></a>

                                    <form action="{{ route('incidencias.destroy', $incidencia) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                    <!-- Aquí podrías agregar botones para editar y eliminar la incidencia -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No existen incidencias</p>
            @endif


        </div>
        <div class="d-flex justify-content-center">
            {{ $incidencias->links() }}
        </div>
        @push('scripts')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    // Maneja el envío del formulario de filtros
                    $('#formFiltros').submit(function(event) {
                        event.preventDefault(); // Evita que se recargue la página al enviar el formulario
                        filtrar(); // Llama a la función de filtrar
                    });

                    // Función para filtrar mediante AJAX
                    function filtrar() {
                        $.ajax({
                            url: '{{ route('incidencias.filtrar') }}', // Ruta definida en las rutas de Laravel
                            type: 'POST',
                            data: $('#formFiltros').serialize(), // Serializa los datos del formulario
                            success: function(response) {
                                $('#lista-incidencias').html(response); // Actualiza la lista de incidencias
                            },
                            error: function(xhr, status, error) {
                                console.error(error); // Maneja los errores, si los hay
                            }
                        });
                    }
                });
            </script>
        @endpush
    </div>
    </div>
    </div>
@endsection
