<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Exportar incidencia</title>
    @vite('resources/sass/app.scss', 'resources/js/app.js', 'resources/sass/_nav.scss')
</head>

<body>

    <div class="bg-colorSecundario rounded-3 p-3">
        <div class="d-flex flex-row gap-3 flex-wrap justify-content-center ">
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
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle" scope="row">
                        <td class="text-truncate">{{ $incidencia->id }}</td>
                        <td class=" text-truncate">{{ $incidencia->fecha_creacion }}</td>
                        <td class="text-truncate" style="max-width: 150px;">{{ $incidencia->descripcion }}</td>
                        <td class=" text-truncate">{{ $incidencia->tipo }}</td>
                        <td class=" text-truncate">{{ $incidencia->equipo->aula->codigo }}</td>
                        <td class=" text-truncate">{{ $incidencia->creador->nombre_completo }}</td>
                        <td class=" text-truncate">
                            @empty($incidencia->responsable_id)
                                Todavía no asignado
                            @else
                                {{ $incidencia->responsable_id }}
                            @endempty
                        </td>
                        <td class=" text-truncate">{{ $incidencia->estado }}</td>
                        <td class="text-truncate">{{ $incidencia->prioridad }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div>
            <form action="{{ route('exports.exportInc', $incidencia) }}" method="POST">
                @csrf
                <button class="btn btn-primary text-white " type="submit">Exportar a Excel</button>
            </form>
            <form action="{{ route('exports.exportpdfInc', $incidencia) }}" method="POST">
                @csrf
                <button class="btn btn-primary text-white " type="submit">Exportar a PDF</button>
            </form>
            <form action="{{ route('exports.exportcsvInc', $incidencia) }}" method="POST">
                @csrf
                <button class="btn btn-primary text-white " type="submit">Exportar a CSV</button>
            </form>
        </div>
    </div>
</body>

</html>
