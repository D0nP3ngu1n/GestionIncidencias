@extends('layouts.plantilla')
@section('titulo', 'Listar equipos')
@section('contenido')
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

    <div class=" border-1 rounded-4 p-2 ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('equipos.index') }}">Equipos</a></li>
            </ol>
        </nav>
        <div class="row my-3 py-3 w-auto rounded-4 bg-colorSecundario">
            <h1 class="text-2xl font-bold mx-8 col-10">Listado de equipos</h1>
        </div>


        <div class="bg-colorSecundario rounded-3 p-3">
            @if (count($equipos) > 0)
                <div class="table-responsive">
                    <table id="tablaIncidencias" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tipo de equipo</th>
                                <th scope="col">Fecha de adquisicion</th>
                                <th scope="col">Etiqueta</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Activo</th>
                                <th scope="col">Aula</th>
                                <th scope="col">Puesto</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipos as $equipo)
                                <tr class="align-middle" scope="row">
                                    <td class="text-truncate">{{ $equipo->id }}</td>
                                    <td class="text-truncate">{{ $equipo->tipo_equipo }}</td>
                                    <td class="text-truncate">{{ $equipo->fecha_adquisicion }}</td>
                                    <td class="text-truncate">{{ $equipo->etiqueta }}</td>
                                    <td class="text-truncate">{{ $equipo->marca }}</td>
                                    <td class="text-truncate">{{ $equipo->modelo }}</td>
                                    <td class="text-truncate">{{ $equipo->descripcion }}</td>

                                    <td class="text-truncate">
                                        @empty($equipo->baja)
                                            Activo
                                        @else
                                            Baja
                                        @endempty
                                    </td>
                                    <td class="text-truncate">{{ $equipo->aula->codigo }}</td>
                                    <td class="text-truncate">{{ $equipo->puesto }}</td>


                                    <td class="text-truncate">
                                        <a href="{{ route('equipos.show', $equipo) }}"
                                            class="btn btn-primary text-white"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('equipos.edit', $equipo) }}"
                                            class="btn btn-success text-white"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('equipos.destroy', $equipo) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h3>No existen equipos</h3>
            @endif
        </div>
    </div>
@endsection
