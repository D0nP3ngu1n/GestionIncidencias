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

<form id="filtroForm" action="{{ route('incidencias.index') }}" method="GET">
    @csrf
    <div class="row mx-5 my-1">
        <!-- Filtro por Tipo -->
        <div class="col">
            <label for="filtro_tipo">Tipo:</label>
            <select name="filtro_tipo" id="filtro_tipo" class="form-control">
                <option value="">Todos</option>
                @php
                    $subtipos = App\Models\IncidenciaSubtipo::all()->unique('tipo'); // Obtener todos los subtipos de incidencia
                @endphp
                @foreach ($subtipos as $subtipo)
                    <option value="{{ $subtipo->tipo }}"
                        {{ request('filtro_tipo') == $subtipo->tipo ? 'selected' : '' }}>
                        {{ $subtipo->tipo }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filtro por Aula -->
        <div class="col">
            <label for="filtro_aula">Aula:</label>
            <select name="filtro_aula" id="filtro_aula" class="form-control">
                <option value="">Todos</option>
                @php
                    $aulas = App\Models\Aula::all()->unique('codigo'); // Obtener todas las aulas
                    echo ' selected="selected"';
                @endphp
                @foreach ($aulas as $aula)
                <option value="{{ $aula->codigo }}" {{ request('filtro_aula') == $aula->codigo ? 'selected' : '' }}>
                    {{ $aula->codigo }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Filtro por Estado -->
        <div class="col">
            <label for="filtro_estado">Estado:</label>
            <select name="filtro_estado" id="filtro_estado" class="form-control">
                <option value="">Todos</option>
                @php
                    $incidenciasE = App\Models\Incidencia::all()->unique('estado'); // Obtener todas las incidencias
                    echo ' selected="selected"';
                @endphp
                @foreach ($incidenciasE as $incidencia)
                    <option value="{{ $incidencia->estado }}"
                        {{ request('filtro_estado') == $incidencia->estado ? 'selected' : '' }}>
                        {{ $incidencia->estado }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filtro por Prioridad -->
        <div class="col">
            <label for="filtro_prioridad">Prioridad:</label>
            <select name="filtro_prioridad" id="filtro_prioridad" class="form-control">
                <option value="">Todos</option>
                @php
                    $incidenciasP = App\Models\Incidencia::all()->unique('prioridad'); // Obtener todas las incidencias
                    echo ' selected="selected"';
                @endphp
                @foreach ($incidenciasP as $incidencia)
                    <option value="{{ $incidencia->prioridad }}"
                        {{ request('filtro_prioridad') == $incidencia->prioridad ? 'selected' : '' }}>
                        {{ $incidencia->prioridad }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mx-5 my-1">
        <button type="submit" id="filtrarBtn" class="btn btn-primary">Aplicar Filtros</button>
    </div>
</form>

        <div class="bg-colorSecundario rounded-3 p-3">
            <div class="d-flex flex-row gap-3 flex-wrap justify-content-center ">

                @forelse ($incidencias as $incidencia)
                    <article class="col-md-4 col-xl-3 card">
                        <a class="text-white text-decoration-none"
                            href='{{ route('incidencias.show', $incidencia) }}'>
                            <div class="card-block">
                                <h6 class="m-b-20">Nº {{ $incidencia->id }}</h6>
                                <h2 class="text-right"><span>{{ $incidencia->descripcion }}</span></h2>
                                <p class="m-b-0">Tipo : {{ $incidencia->tipo }}<span class="f-right"></span></p>
                                <p class="m-b-0">Aula:<span
                                        class="f-right">{{ $incidencia->equipo->aula->codigo }}</span>
                                </p>
                                <p class="m-b-0">Creado por: <span
                                        class="f-right">{{ $incidencia->creador->nombre }}</span></p>
                                <p class="m-b-0">Responsable:<span class="f-right">
                                    @empty($incidencia->responsable_id)
                                        todavia no asignada
                                    @else
                                        {{ $incidencia->responsable_id }}
                                    @endempty
                                </span></p>
                            <p class="m-b-0">Estado<span
                                    class="f-right estado">{{ $incidencia->estado }}</span></p>
                            <p class="m-b-0">Prioridad<span
                                    class="f-right">{{ $incidencia->prioridad }}</span></p>

                        </div>
                    </a>
                </article>

            @empty
                <p>No existen Incidencias</p>
            @endforelse
            <script>
                // Seleccionamos todos los elementos que tienen la clase 'card'
                var cards = document.querySelectorAll('.card');

                // Iteramos sobre cada tarjeta
                cards.forEach(function(card) {
                    // Obtenemos el estado de la incidencia
                    var estadoIncidencia = card.querySelector('.estado').innerText.trim();

                    // Verificamos el estado y cambiamos la clase según corresponda
                    switch (estadoIncidencia) {
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
                    }
                });
            </script>
        </div>
        <div class="d-flex justify-content-center">
            {{ $incidencias->links() }}
        </div>
    </div>
</div>
</div>
@endsection
