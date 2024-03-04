@extends('layouts.plantilla')
@section('titulo', 'Listar equipos')
@section('contenido')

    <div class="border-1 rounded-4 p-2 ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Equipos</li>
            </ol>
        </nav>
        <div class="row my-3 py-3 w-auto rounded-4 bg-colorSecundario">
            <h1 class="text-2xl font-bold mx-8 col-10">Listado de equipos</h1>
            <div class="col -2">
                <a id="botonCrear" href="{{ route('equipos.create') }}">
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
                    <span>Crear Equipo</span>
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

        <!-- Fin Filtros -->
        @if (count($equipos) > 0)
            <div class="table-responsive">
                <table id="tablaIncidencias" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fecha de adquisicion</th>
                            <th scope="col">Etiqueta</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Activo</th>
                            <th scope="col">aula</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($equipos as $equipo)
                            <tr class="align-middle" scope="row">
                                <td class="text-truncate">{{ $equipo->id }}</td>
                                <td class="text-truncate">{{ $equipo->fecha_adquisicion }}</td>
                                <td class="text-truncate" >{{ $equipo->etiqueta }}</td>
                                <td class="text-truncate">{{ $equipo->marca }}</td>
                                <td class="text-truncate">{{ $equipo->modelo }}</td>
                                <td class="text-truncate" style="max-width: 150px;">{{ $equipo->descripcion }}</td>
                                <td class="text-truncate">
                                    @empty($equipo->baja)
                                        Activo
                                    @else
                                        Baja
                                    @endempty
                                </td>
                                <td class="text-truncate">{{ $equipo->aula->codigo }}</td>
                                <td>
                                    <div class="d-flex gap-3">


                                        <a class="btn btn-primary text-white" role="button"
                                            href="{{ route('equipos.show', $equipo) }}">
                                            <i class="bi bi-eye"></i>
                                        </a>


                                        <a class="btn btn-success" role="button"
                                            href="{{ route('equipos.edit', $equipo) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>


                                        <form action="{{ route('equipos.destroy', $equipo) }}" method="POST"
                                            id="formBorrar">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                        <script>
                                            // Seleccionar todos los elementos con el id #formBorrar
                                            var forms = document.querySelectorAll('#formBorrar');

                                            // Iterar sobre cada elemento y agregar un evento de escucha
                                            forms.forEach(function(form) {
                                                form.addEventListener('submit', function(e) {
                                                    e.preventDefault();

                                                    var currentForm = this;

                                                    swal({
                                                        title: "Borrar Equipo",
                                                        text: "¿Quieres borrar el equipo?",
                                                        icon: "warning",
                                                        buttons: [
                                                            'No, cancelar',
                                                            'Si, Estoy Seguro'
                                                        ],
                                                        dangerMode: true,
                                                    }).then(function(isConfirm) {
                                                        if (isConfirm) {
                                                            swal({
                                                                title: '¡HECHO!',
                                                                text: 'El equipo ha sido borrada',
                                                                icon: 'success'
                                                            }).then(function() {
                                                                currentForm.submit();
                                                            });
                                                        } else {
                                                            swal("Cancelado", "El equipo no ha sido eliminada", "error");
                                                        }
                                                    });
                                                });
                                            });
                                        </script>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h2 class="text-center">No existen Equipos</h2>
        @endif
    </div>



    <div class="d-flex justify-content-center">
        {{ $equipos->links() }}
    </div>
    </div>
    </div>
    </div>
@endsection
