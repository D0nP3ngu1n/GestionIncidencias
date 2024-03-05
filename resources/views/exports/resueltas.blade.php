
<div>
    <table>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tipo</th>
                <th scope="col">Subtipo</th>
                <th scope="col">Fecha creacion</th>
                <th scope="col">Fecha Cierre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Estado</th>
                <th scope="col">Creador</th>
                <th scope="col">Responsable</th>
                <th scope="col">Duracion</th>
                <th scope="col">Prioridad</th>
            </tr>
        </thead>
        @foreach ($incidencias as $incidencia)
            <tr>
                <td>{{ $incidencia->id }}</td>
                <td>{{ $incidencia->tipo }}</td>
                <td>{{ $incidencia->subtipo_id }}</td>
                <td>{{ $incidencia->fecha_creacion }}</td>
                <td>{{ $incidencia->fecha_cierre }}</td>
                <td>{{ $incidencia->descripcion }}</td>
                <td>{{ $incidencia->estado }}</td>
                <td>{{ $incidencia->creador->nombre_completo }}</td>
                @if ($incidencia->responsable && $incidencia->responsable->nombre_completo)
                    <td>{{ $incidencia->responsable->nombre_completo }}</td>
                @else
                    <td>No asignado</td>
                @endif
                <td>{{ $incidencia->duracion }}</td>
                <td>{{ $incidencia->prioridad }}</td>
            </tr>
        @endforeach
    </table>
</div>
