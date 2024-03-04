@extends('layouts.plantilla')
@section('titulo', 'Listar Aulas')
@section('contenido')

    <div class="border-1 rounded-4 p-2 ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Aulas</li>
            </ol>
        </nav>
        <div class="row my-3 py-3 w-auto rounded-4 bg-colorSecundario">
            <h1 class="text-2xl font-bold mx-8 col-10">Listado de aulas</h1>
            <div class="col -2">
                <a id="botonCrear" href="{{ route('aulas.create') }}">
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
                    <span>Añadir aula</span>
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
        @if (count($aulas) > 0)
            <div class="table-responsive">
                <table id="tablaIncidencias" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">codigo</th>
                            <th scope="col">planta</th>
                            <th scope="col">descripcion</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aulas as $aula)
                            <tr class="align-middle" scope="row">
                                <td class="text-truncate">{{ $aula->num }}</td>
                                <td class="text-truncate">{{ $aula->codigo }}</td>
                                <td class="text-truncate">{{ $aula->planta }}</td>
                                <td class="text-truncate">{{ $aula->descripcion }}</td>
                                <td class="col-1">
                                    <div class="d-flex gap-3">
                                        <a class="btn btn-primary text-white" role="button"
                                            href="{{ route('aulas.show', $aula) }}">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a class="btn btn-success" role="button"
                                            href="{{ route('aulas.edit', $aula) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('aulas.destroy', $aula) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No existen aulas</p>
        @endif
    </div>



    <div class="d-flex justify-content-center">
        {{-- {{ $aulas->links() }} --}}
    </div>
    </div>
    </div>
    </div>
@endsection
