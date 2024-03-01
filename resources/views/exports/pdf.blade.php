<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Incidencias</title>
</head>

<body>
    <div>
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
                                {{ $incidencia->equipo->aula->codigo ?? '' }}
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
