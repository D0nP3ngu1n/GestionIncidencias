@extends('layouts.plantilla')
@section('titulo', 'Listar usuarios')
@section('contenido')
    <div class=" border-1 rounded-4 p-2 ">
        <div class="row my-3 py-3 w-auto rounded-4 bg-colorSecundario">
            <h1 class="text-2xl font-bold mx-8 col-10">Listado de usuarios</h1>
            <div class="col -2">
                <a id="botonCrear" href="{{ route('usuarios.create') }}">
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
                    <span>Crear Usuario</span>
                </a>
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
        {{-- <form action="{{ route('incidencias.index') }}" method="GET">
        <div class="form-group">
            <label for="tipo">Filtrar por tipo:</label>
            <select name="tipo" id="tipo" class="form-control">
                <option value="">Todos</option>
                <option value="tipo1">Tipo 1</option>
                <option value="tipo2">Tipo 2</option>
                <!-- Agregar más opciones según sea necesario -->
            </select>
        </div>
        <div class="form-group">
            <label for="estado">Filtrar por estado:</label>
            <select name="estado" id="estado" class="form-control">
                <option value="">Todos</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
                <!-- Agregar más opciones según sea necesario -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
    </form> --}}

        <div class="bg-colorSecundario rounded-3 p-3">
            <div class="d-flex flex-row gap-3 flex-wrap justify-content-center ">

                @forelse ($usuarios as $usuario)
                    <article class="col-md-4 col-xl-3 card">
                        <a class="text-white text-decoration-none" href='{{ route('usuarios.show', $usuario) }}'>
                            <div class="card-block">
                                <h6 class="m-b-20">Nº {{ $usuario->id }}</h6>
                                <h2 class="text-right"><span>Nombre :{{ $usuario->nombreCompleto }}</span></h2>
                                <p class="m-b-0"><span class="f-right">email : {{ $usuario->email }}</span></p>
                            </div>
                        </a>
                    </article>

                @empty
                    <p>No existen usuarios</p>
                @endforelse
                <div class="d-flex justify-content-center">
                    {{ $usuarios->links() }}
                </div>
                <script>
                    // Seleccionamos todos los elementos que tienen la clase 'card'
                    var cards = document.querySelectorAll('.card');

                    // Iteramos sobre cada tarjeta
                    cards.forEach(function(card) {
                        // Obtenemos el estado de la incidencia
                        //var estadoIncidencia = card.querySelector('.estado').innerText.trim();
                        card.classList.add('bg-c-blue');

                        // Verificamos el estado y cambiamos la clase según corresponda
                        /*switch (estadoIncidencia) {
                            case 'abierta':
                                card.classList.add('bg-c-red');
                                break;
                            case 'en proceso':
                                card.classList.add('bg-c-yellow');
                                break;
                            case 'cerrada':
                                card.classList.add('bg-c-green');
                                break;
                            case 'enviada a Infortec':
                                card.classList.add('bg-c-yellow');
                                break;
                            case 'asignada':
                                card.classList.add('bg-c-yellow');
                                break;
                            default:
                                card.classList.add('bg-c-green');

                                break;
                        }*/
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
