@extends('layouts.plantilla')
@section('titulo', 'Listar usuarios')
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
                <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
            </ol>
        </nav>
        <div class="row my-3 py-3 w-auto rounded-4 bg-colorSecundario">
            <h1 class="text-2xl font-bold mx-8 col-10">Listado de usuarios</h1>
        </div>


        <div class="bg-colorSecundario rounded-3 p-3">
            @if (count($usuarios) > 0)
                <div class="table-responsive">
                    <table id="tablaIncidencias" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Nombre del Dominio</th>
                                <th scope="col">Email</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">Rol</th>
                                <th scope="col" class='col-1'>Acciones</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr class="align-middle" scope="row">
                                    <td class="text-truncate">{{ $usuario->id }}</td>
                                    <td class="text-truncate">{{ $usuario->nombre_completo }}</td>
                                    <td class="text-truncate">{{ $usuario->name }}</td>
                                    <td class="text-truncate">
                                        @empty($usuario->email)
                                            Todavía no asignado
                                        @else
                                            {{ $usuario->email }}
                                        @endempty
                                    </td>
                                    <td class="text-truncate">
                                        @empty($usuario->departamento_id)
                                            Todavía no asignado
                                        @else
                                            {{ $usuario->departamento->nombre }}
                                        @endempty
                                    </td>
                                    <td class="text-truncate">
                                        {{-- @if ($usuario->hasRole('Profesor'))
                                        Profesor
                                    @else
                                        Administrador
                                    @endif --}}
                                        {{ $usuario->getRol() }}
                                    </td>


                                    <td class="text-truncate">
                                        <a href="{{ route('usuarios.show', $usuario) }}"
                                            class="btn btn-primary text-white"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('usuarios.edit', $usuario) }}"
                                            class="btn btn-success text-white"><i class="bi bi-pencil-square"></i></a>
                                        <!-- Aquí podrías agregar botones para editar y eliminar la incidencia -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                <h2 class="text-center">No existen incidencias</h2>
            @endif
        </div>
    </div>
@endsection
